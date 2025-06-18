<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'selling_price',
        'cost_price',
        'profit',
    ];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'item_id')->where('type', 'product');
    }

    public function isLowStock()
    {
        return $this->stock < 5;
    }
}