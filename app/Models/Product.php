<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'state'];

    protected $hidden = ['state', 'created_at', 'updated_at'];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'clients_products');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
