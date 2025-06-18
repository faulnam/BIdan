<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'staff_fee',
        'profit',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'staff_fee' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'item_id')->where('type', 'service');
    }
}