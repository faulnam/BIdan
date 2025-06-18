<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'date_of_birth',
        'phone',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getTotalSpentAttribute()
    {
        return $this->transactions()->sum('total');
    }
}