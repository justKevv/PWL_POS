<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey ='id_user';

    protected $fillable = [
        'id_level', 'username', 'name', 'password'
    ];

    public function level() {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
}
