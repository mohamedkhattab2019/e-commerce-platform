<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetails extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'address', 'city', 'state', 'zip_code', 'country', 'phone'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
