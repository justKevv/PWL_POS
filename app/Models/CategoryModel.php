<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = "m_category";

    protected $primaryKey = "id_category";

    protected $fillable = [
        "code_category",
        "name_category"
    ];
}
