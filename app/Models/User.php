<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'UserID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Name', 'MatricNo', 'Email', 'Password', 'Role', 'MedicalHistory',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->Role === 'admin';
    }
}
