<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'User'; // Custom table name
    protected $primaryKey = 'UserID';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Email',
        'Password',
        'MatricNo',
        'PhoneNumber',
        'MedicalHistory',
    ];

    protected $hidden = [
        'Password',
    ];
}
