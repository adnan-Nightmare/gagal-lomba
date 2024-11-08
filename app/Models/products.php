<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['slug','judul', 'description', 'thumbnail' ,'price', 'toko', 'stock_quantity'];

    public function store()
    {
        return $this->belongsToMany(Store::class, 'store_products', 'store_id','product_id');
    }

    public function category(){
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id',	'category_id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

}
