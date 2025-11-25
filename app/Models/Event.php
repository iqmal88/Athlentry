<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'EventID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'EventName',
        'Location',
        'StartDate',
        'EndDate',
        'Description',
        'CreatedBy',
        'Status',
    ];

    protected $casts = [
    'StartDate' => 'date',
    'EndDate' => 'date',
    ];


    // Relations
    public function games()
    {
        return $this->hasMany(GameInfo::class, 'EventID', 'EventID');
    }

    // Optionally: creator user relation (if CreatedBy stores UserID)
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'CreatedBy', 'UserID');
    }
}
