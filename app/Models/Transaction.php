<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'patient_id',
        'user_id',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaction_id = 'TRX' . now()->format('YmdHis') . rand(100, 999);
        });
    }
}