<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF; // Tambahkan ini untuk PDF

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['patient', 'user', 'items']);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Date filter
        if ($request->has('date_filter') && $request->date_filter !== 'all') {
            $today = Carbon::today();
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', $today);
                    break;
                case 'week':
                    $query->whereBetween('created_at', [$today->copy()->subWeek(), $today->copy()->addDay()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', $today->month)
                          ->whereYear('created_at', $today->year);
                    break;
            }
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $patients = Patient::all();
        $services = Service::all();
        $products = Product::where('stock', '>', 0)->get();

        return view('transactions.create', compact('patients', 'services', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:service,product',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                if ($item['type'] === 'service') {
                    $service = Service::findOrFail($item['id']);
                    $itemTotal = $service->price * $item['quantity'];
                    $items[] = [
                        'type' => 'service',
                        'item_id' => $service->id,
                        'item_name' => $service->name,
                        'quantity' => $item['quantity'],
                        'price' => $service->price,
                        'total' => $itemTotal,
                    ];
                } else {
                    $product = Product::findOrFail($item['id']);

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok tidak cukup untuk {$product->name}");
                    }

                    $itemTotal = $product->selling_price * $item['quantity'];
                    $items[] = [
                        'type' => 'product',
                        'item_id' => $product->id,
                        'item_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'price' => $product->selling_price,
                        'total' => $itemTotal,
                    ];

                    $product->decrement('stock', $item['quantity']);
                }

                $total += $itemTotal;
            }

            $transaction = Transaction::create([
                'patient_id' => $request->patient_id,
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'completed',
            ]);

            foreach ($items as $item) {
                $transaction->items()->create($item);
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['patient', 'user', 'items']);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Download or print transaction as PDF.
     */
    public function downloadPDF(Transaction $transaction)
    {
        $transaction->load(['patient', 'user', 'items']);

        $pdf = PDF::loadView('transactions.pdf', compact('transaction'))
                  ->setPaper('A5', 'portrait');

        return $pdf->download('transaction_' . $transaction->id . '.pdf');
    }
}
