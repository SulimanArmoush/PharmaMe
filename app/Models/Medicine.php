<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'scName',
        'trName',
        'category_id',
        'manufacturer',
        'quantity',
        'expDate',
        'price',
        'user_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_medicines');
    }
}
