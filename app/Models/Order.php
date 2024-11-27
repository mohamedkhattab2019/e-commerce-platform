<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'guest_token','subtotal', 'tax', 'total', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingDetails()
    {
        return $this->hasOne(ShippingDetails::class);
    }

    public function paymentDetails()
    {
        return $this->hasOne(PaymentDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
