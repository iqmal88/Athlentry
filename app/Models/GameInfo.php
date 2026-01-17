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
        'TimeStart' => 'string',
        'TimeEnd'   => 'string',
    ];

    /* =========================
     | RELATIONSHIPS
     ========================= */

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'GameID', 'GameID');
    }

    /* =========================
     | HELPER METHODS (FOR CLASH LOGIC)
     ========================= */

    /**
     * Check if this game overlaps with another game
     */
    public function overlapsWith(GameInfo $other): bool
    {
        if ($this->GameDate->ne($other->GameDate)) {
            return false;
        }

        return !(
            $this->TimeEnd <= $other->TimeStart ||
            $this->TimeStart >= $other->TimeEnd
        );
    }

    public function getTimeStartAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getTimeEndAttribute($value)
    {
        return substr($value, 0, 5);
    }
}
