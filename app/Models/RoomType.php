<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'accommodation', 'quantity', 'hotel_id'];

    protected $dates = ['deleted_at'];
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    use HasFactory;
}
