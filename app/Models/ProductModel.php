<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = "m_product";

    protected $primaryKey = "id_product";

    protected $fillable = [
        'product_code',
        'product_name',
        'id_category',
        'purchase_price',
        'selling_price',
    ];
    public function category() {
        return $this->belongsTo(CategoryModel::class, "id_category", "id_category");
    }
}
