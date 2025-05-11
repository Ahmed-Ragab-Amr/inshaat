<?php

namespace App\Models;

use App\Models\ConsaltantProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConstractorOffer extends Model
{
    use HasFactory;

    protected $fillable = ['technical' , 'plan' , 'table' , 'user_id' , 'project_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consaltant_project()
    {
        return $this->belongsTo(ConsaltantProject::class);
    }
}
