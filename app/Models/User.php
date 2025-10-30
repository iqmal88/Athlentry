<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'User'; // 
    protected $primaryKey = 'UserID';

    protected $fillable = [
        'Name',
        'Email',
        'MatricNo',
        'PhoneNumber',
        'Password',
        'MedicalHistory',
    ];

    protected $hidden = [
        'Password',
    ];
}
