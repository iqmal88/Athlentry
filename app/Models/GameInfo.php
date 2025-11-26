<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameInfo extends Model
{
    protected $table = 'game_info';
    protected $primaryKey = 'GameID';
    public $timestamps = true;

    protected $fillable = [
        'EventID',
        'GameName',
        'Category',
        'GameDate',
        'GameTime',
        'SelectionPlace',
        'CoachName',
        'CoachPhone',
        'Capacity',
        'Rules',
        'Description',
        'Status'
    ];

    // Relationship to parent event
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class, 'EventID', 'EventID');
    }

    // Relationship to applications (optional/useful)
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'GameID', 'GameID');
    }

    /**
     * Effective status: if parent event is not Open, return the event's status,
     * otherwise return the game's own Status.
     *
     * Usage in blade: $game->final_status
     */
    public function getFinalStatusAttribute()
    {
        // ensure event relationship available
        if (! $this->relationLoaded('event')) {
            $this->load('event');
        }

        if ($this->event && in_array($this->event->Status, ['Closed', 'Cancelled'])) {
            return $this->event->Status;
        }

        return $this->Status ?? 'Open';
    }
}
