<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Admin extends Authenticatable
{
    use HasFactory, \Illuminate\Auth\Authenticatable;

    //  protected $guard = 'admin';
     protected $table = 'admins';
    protected $fillable = ['username', 'password'];

    protected $hidden = ['password'];
}
