<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\PricingPlans\Contracts\Subscriber;
use Laravel\PricingPlans\Models\Concerns\Subscribable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements Subscriber
{
    use Notifiable;
    use Subscribable;
    use HasRoleAndPermission;

    // protected $fillable = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
