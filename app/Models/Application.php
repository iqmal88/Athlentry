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

        // Status system
        'ApplicationStatus',
        'SelectionStatus',

        // Applicant info
        'Achievement',
        'MedicalHistory',
        'DateApplied',
    ];

    protected $casts = [
        'DateApplied'      => 'date',
    ];

    /* =========================
     | RELATIONSHIPS
     ========================= */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(GameInfo::class, 'GameID', 'GameID');
    }

    /* =========================
     | STATUS HELPERS
     ========================= */

    public function isPending(): bool
    {
        return $this->ApplicationStatus === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->ApplicationStatus === 'approved';
    }

    public function isRejected(): bool
    {
        return in_array($this->ApplicationStatus, ['rejected', 'withdrawn']);
    }

    public function isInSelection(): bool
    {
        return $this->SelectionStatus === 'in_selection';
    }

    public function isSelected(): bool
    {
        return $this->SelectionStatus === 'selected';
    }

    public function isSelectionRejected(): bool
    {
        return $this->SelectionStatus === 'rejected';
    }
}
