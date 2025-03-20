<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 't_sales';

    protected $primaryKey = 'id_sales';

    protected $fillable = [
        'id_user',
        'buyer',
        'sales_code',
        'sales_date'
    ];

    public function user() {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }

    public function detail() {
        return $this->hasMany(SalesDetail::class, 'id_sales', 'id_sales');
    }

    protected function getTotalAttribute() {
        return $this->detail->sum('subtotal');
    }
}
