<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'document', 'email', 'state'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'clients_products');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
