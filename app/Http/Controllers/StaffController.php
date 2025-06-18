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
        // Only admin can access staff management
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $staff = User::where('role', 'staff')->get();

        foreach ($staff as $member) {
            $transactions = Transaction::where('user_id', $member->id)->get();
            $member->total_transactions = $transactions->count();
            $member->total_revenue = $transactions->sum('total');
            
            $monthlyTransactions = $transactions->filter(function($transaction) {
                return $transaction->created_at->month === Carbon::now()->month &&
                       $transaction->created_at->year === Carbon::now()->year;
            });
            
            $member->monthly_transactions = $monthlyTransactions->count();
            $member->monthly_revenue = $monthlyTransactions->sum('total');
        }

        return view('staff.index', compact('staff'));
    }
}