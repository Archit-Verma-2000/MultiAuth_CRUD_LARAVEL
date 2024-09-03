<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MultiAuth extends Authenticatable
{
    use Notifiable;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'tb_multi_auth';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'email',
        'password',
    ];

    // Hide attributes that shouldn't be visible when the model is serialized
    protected $hidden = [
        'password',
        'remember_token', // Add this if you plan to use remember tokens
    ];

    // Cast attributes to their appropriate types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
