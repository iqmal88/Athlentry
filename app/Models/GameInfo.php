<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameInfo extends Model
{
    protected $table = 'game_info';
    protected $primaryKey = 'GameID';
    public $incrementing = true;
    protected $keyType = 'int';

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
        'Status',
    ];

    protected $casts = [
        'GameDate' => 'date',
        'GameTime' => 'string',
    ];

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    public function applications()
    {
        // Application uses GameID foreign key
        return $this->hasMany(Application::class, 'GameID', 'GameID');
    }

    // Count of accepted applications (helper)
    public function acceptedApplications()
    {
        // assumes StatusID maps to statuses table; you can adapt the status id for "accepted"
        return $this->applications()->whereHas('status', function($q){
            $q->where('Name', 'Accepted');
        });
    }
}
