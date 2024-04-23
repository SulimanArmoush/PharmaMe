<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price',


    ];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medicines');
    }
}
