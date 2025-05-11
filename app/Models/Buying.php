<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    use HasFactory;

    protected $fillable = ['location' , 'desired_location1' , 'desired_location2' , 'desired_location3' , 'phone' , 'images' , 'status' , 'area' , 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
