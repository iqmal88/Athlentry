<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'ApplicationID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'UserID',
        'EventID',
        'GameID',
        'StatusID',
        'SportType',
        'Achievement',
        'MedicalHistory',
        'DateApplied',
        'SnapshotEventName',
        'SnapshotGameName',
        'SnapshotGameDate',
        'SnapshotLocation',
        'SnapshotCapacity',
    ];

    protected $casts = [
        'DateApplied'      => 'datetime',
        'SnapshotGameDate' => 'date',
    ];

    /**
     * Application belongs to a user (applicant)
     * Adjust the foreign / owner keys if your users table uses 'id' instead of 'UserID'
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'UserID', 'UserID');
    }

    /**
     * Application belongs to an event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    /**
     * Application belongs to a game
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(GameInfo::class, 'GameID', 'GameID');
    }

    /**
     * Application belongs to a status
     */
        public function status()
    {
        return $this->belongsTo(Status::class, 'StatusID', 'StatusID');
    }
}
