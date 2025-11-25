<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'ApplicationID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'UserID',
        'GameID',
        'StatusID',
        'SportType',
        'Achievement',
        'MedicalHistory',
        'DateApplied',
        // snapshot fields
        'SnapshotEventName',
        'SnapshotGameName',
        'SnapshotGameDate',
        'SnapshotLocation',
        'SnapshotCapacity',
    ];

    protected $casts = [
        'DateApplied' => 'datetime',
        'SnapshotGameDate' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserID', 'UserID');
    }

    public function game()
    {
        return $this->belongsTo(GameInfo::class, 'GameID', 'GameID');
    }

    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'StatusID', 'StatusID');
    }
}
