<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;
    protected $table = 't_sales_detail';

    protected $primaryKey = 'id_sales_detail';

    protected $fillable = [
        'id_sales',
        'id_product',
        'qty',
        'price',
    ];

    public function sales() {
        return $this->belongsTo(Sales::class, 'id_sales', 'id_sales');
    }

    public function product() {
        return $this->belongsTo(ProductModel::class, 'id_product', 'id_product');
    }

    protected function getSubtotalAttribute()
    {
        return $this->price * $this->qty;
    }
}
