<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = "m_level";

    protected $primaryKey = "id_level";

    protected $fillable = ['code_level', 'name_level'];
}
