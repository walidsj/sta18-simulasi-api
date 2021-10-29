<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'npm',
        'email',
        'major_id',
        'user_bio_id',
        'email_verified_at',
        'password',
        'role',
        'user_type_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_bio_id',
        'password',
        'remember_token',
        'updated_at'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class);
    }

    public function user_score()
    {
        return $this->hasOne(ViewUserScore::class);
    }
}
