<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        // Batasi akses hanya untuk admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Ambil semua staf (user dengan role 'staff')
        $staff = User::where('role', 'staff')->get();

        // Ambil semua transaksi
        $allTransactions = Transaction::all();

        // Loop tiap staf dan hitung statistik
        foreach ($staff as $member) {
            // Filter transaksi milik staf ini
            $transactions = $allTransactions->where('user_id', $member->id);

            // Total transaksi dan pendapatan
            $member->total_transactions = $transactions->count();
            $member->total_revenue = $transactions->sum('total');

            // Transaksi dan pendapatan bulan ini
            $monthlyTransactions = $transactions->filter(function ($transaction) {
                return $transaction->created_at->month === Carbon::now()->month &&
                       $transaction->created_at->year === Carbon::now()->year;
            });

            $member->monthly_transactions = $monthlyTransactions->count();
            $member->monthly_revenue = $monthlyTransactions->sum('total');

            // Tambahan: Total fee yang didistribusikan ke staf (misalnya 20% dari total transaksi)
            $member->total_fees = $transactions->sum(function ($trx) {
                return $trx->staff_fee ?? 0; // asumsi ada kolom `staff_fee`
            });
        }

        // Kirim data staf dan transaksi ke view
        return view('staff.index', [
            'staff' => $staff,
            'transactions' => $allTransactions
        ]);
    }
}
