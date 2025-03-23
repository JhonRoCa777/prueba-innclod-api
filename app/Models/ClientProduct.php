<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProduct extends Model
{
    use HasFactory;

    protected $table = 'clients_products';

    protected $fillable = ['client_id', 'product_id'];
}
