<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'total_amount', 'shipping_method', 'address', 'payment_method', 'status'];

    public function updateStatus(){
        $timer = Carbon::now()->diffInMinutes($this->created_at);

        if ($timer >= 10) {
            if ($this->status == 'pending') {
                $this->status = 'processing';
            } elseif ($this->status == 'processing') {
                $this->status = 'shipped';
            } elseif ($this->status == 'shipped') {
                $this->status = 'delivered';
            }

            $this->save();
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(){
        return $this->belongsTo(ShippingMethod::class);
    }
}
