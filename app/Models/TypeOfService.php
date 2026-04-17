<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfService extends Model
{
    use SoftDeletes;

    protected $table = 'type_of_service';
    protected $fillable = ['service_name', 'price', 'description'];

    // Relasi: satu service bisa muncul di banyak order detail
    public function orderDetails()
    {
        return $this->hasMany(TransOrderDetail::class , 'id_service');
    }
}