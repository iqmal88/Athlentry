<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'TimeStart',
        'TimeEnd',
        'SelectionPlace',
        'CoachName',
        'CoachPhone',
        'Capacity',
        'Rules',
        'Description',
        'Status',
    ];

    protected $casts = [
        'GameDate'  => 'date',
        'TimeStart' => 'string', // IMPORTANT
        'TimeEnd'   => 'string', // IMPORTANT
    ];

    /* RELATIONSHIPS */

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'GameID', 'GameID');
    }
}
