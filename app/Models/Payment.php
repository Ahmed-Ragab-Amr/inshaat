<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'expire' , 'number' , 'safe' ,'user_id' , 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
