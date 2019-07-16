<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'status', 'activation_code', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
