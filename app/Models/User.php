<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {
  use HasFactory;
  protected $primaryKey = 'UserID'; // if you used that earlier
  protected $fillable = ['Name','MatricNo','Email','Password','Role','MedicalHistory'];
  protected $hidden = ['Password','remember_token'];
  public function getAuthPassword(){ return $this->Password; } // if column name is Password
}

