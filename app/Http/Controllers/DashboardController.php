<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_services' => Service::count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'low_stock_products' => Product::where('stock', '<', 5)->count(),
            'total_revenue' => Transaction::sum('total'),
            'today_transactions' => Transaction::whereDate('created_at', Carbon::today())->count(),
        ];

        $recent_transactions = Transaction::with(['patient', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = Product::where('stock', '<', 5)
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_transactions', 'low_stock_products'));
    }
}