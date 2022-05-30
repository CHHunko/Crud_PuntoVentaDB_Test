<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'persona';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'idpersona';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    public $incrementing = false;

    public $timestamps = false;

    const CREATED_AT = 'fechacreacion';


    public function getAuthPassword() {
        return bcrypt($this->password);
    }
}
