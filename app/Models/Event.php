<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'EventID';
    public $timestamps = true;

    protected $fillable = [
        'EventName',
        'Location',
        'StartDate',
        'EndDate',
        'Description',
        'CreatedBy',
        'Status',
        'MaxGamesPerStudent',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate'   => 'date',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(GameInfo::class, 'EventID', 'EventID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'EventID', 'EventID');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
    }
}
