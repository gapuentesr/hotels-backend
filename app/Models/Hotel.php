<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'address', 'city', 'nit', 'number_of_rooms'];

    protected $dates = ['deleted_at'];
    
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }    
    
    use HasFactory;
}
