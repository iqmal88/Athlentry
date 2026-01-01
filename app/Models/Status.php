<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    // Table name (optional, but good practice since ID is custom)
    protected $table = 'statuses';

    // Primary key
    protected $primaryKey = 'StatusID';

    // Allow mass assignment
    protected $fillable = [
        'StatusName',
        'Selection',
    ];

    public function applications()
{
    return $this->hasMany(Application::class, 'StatusID', 'StatusID');
}
}
