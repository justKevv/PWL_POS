<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    use HasFactory;

    protected $table = 't_stock';

    protected $primaryKey = 'id_stock';

    protected $fillable = [
        'id_product',
        'id_user',
        'date_stock',
        'stock_quantity',
    ];

    public function product() {
        return $this->belongsTo(ProductModel::class, 'id_product', 'id_product');
    }

    public function user() {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }
}
