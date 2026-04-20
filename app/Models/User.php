<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'users';
    protected $fillable = ['role_id', 'name', 'email', 'password'];
    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi: user punya satu role
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
