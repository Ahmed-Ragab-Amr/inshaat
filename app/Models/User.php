<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ConstractorOffer;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'image',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

      /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function buyings()
    {
        return $this->hasMany(Buying::class);
    }

    public function consaltant_projects()
    {
        return $this->hasMany(ConsaltantProject::class);
    }

    public function constractor_offers()
    {
        return $this->hasMany(ConstractorOffer::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function provider()
    {
        return $this->hasOne(Provider::class);
    }
}
