<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = ['product_name', 'product_weight', 'product_price', 'product_amount', 'product_type'];

    private $productTypes = ['Cake', 'Pie'];


    public function interested()
    {
        return $this->hasMany(Interested::class, 'product_id', 'product_id');
    }
}
