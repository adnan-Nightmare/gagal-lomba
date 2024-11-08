<?php

namespace App\Models;

use App\Models\products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class store extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description'];

    public function products(){
        return $this->belongsToMany(products::class, 'store_products','store_id','product_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
