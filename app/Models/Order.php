<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_id',
        'totalPrice',
        'status',
        'paymentStatus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function Medicine()
    {
        return $this->hasMany(OrderMedicine::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'order_medicines')     
        ->withPivot('quantity'); 
    }
}
