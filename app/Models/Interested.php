<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interested extends Model
{
    use HasFactory;

    protected $table = 'interested';

    protected $primaryKey = 'interested_id';

    protected $fillable = ['product_id', 'interested_name', 'interested_email', 'interested_sent'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
