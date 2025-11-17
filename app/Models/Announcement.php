<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    // Primary key is AnnouncementID (not the default id)
    protected $primaryKey = 'AnnouncementID';

    // If your PK is not auto-incrementing integer, set $incrementing=false. 
    // In your migration you used id() so it's incrementing — leave default.
    // protected $keyType = 'int';

    protected $fillable = [
        'Location',
        'Title',
        'Date',
        'Description',
        'CreatedBy',
    ];

    // Optional: cast Date to date object
    protected $casts = [
        'Date' => 'date',
    ];

    // If you want an easy accessor for a human readable date
    public function getFormattedDateAttribute()
    {
        if (!$this->Date) return null;
        return $this->Date->format('j F Y, l'); // e.g. 31 March 2025, Sunday
    }

    // Relationship to User (optional)
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'CreatedBy', 'UserID');
    }
}
