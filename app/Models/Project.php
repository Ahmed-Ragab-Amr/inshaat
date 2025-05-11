<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['alhy' , 'area' , 'style' , 'finish_level' , 'house_shape' , 'design' , 'floor_number' , 'sitting_number' , 'kitchen_number' , 'dining_room' , 'guest_bedroom' , 'other_room' , 'bedroom_number' , 'parking_number' , 'other_addition' , 'notes' , 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
