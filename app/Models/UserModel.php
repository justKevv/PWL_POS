<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey ='id_user';

    protected $fillable = [
        'id_level', 'username', 'name', 'password', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function level() {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    public function getRoleName() {
        return $this->level->name_level;
    }

    public function hasRole($role) {
        return $this->level->code_level == $role;
    }

    public function getRole() {
        return $this->level->code_level;
    }
}
