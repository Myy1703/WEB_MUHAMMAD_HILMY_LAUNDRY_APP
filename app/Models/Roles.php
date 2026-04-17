<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $fillable = ['roles_name'];

    // Relasi: satu roles punya banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
