<?php

namespace App\Models;

use App\Models\ConstractorOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsaltantProject extends Model
{
    use HasFactory;

    protected $fillable = ['technical' , 'plan' , 'table' , 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function costractor_offers()
    {
        return $this->hasMany(ConstractorOffer::Class);
    }
}
