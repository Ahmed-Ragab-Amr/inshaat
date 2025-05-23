<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['number' , 'image' , 'status' , 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
