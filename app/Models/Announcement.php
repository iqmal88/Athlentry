<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'announcements';
    protected $primaryKey = 'AnnouncementID';

    protected $fillable = [
        'Title',
        'Location',
        'Date',
        'TimeFrom',
        'TimeUntil',
        'Description',
        'Image',
        'CreatedBy',
    ];

    protected $casts = [
        'Date'      => 'date',
        'TimeFrom'  => 'datetime:H:i',   // Stored as TIME, returned as Carbon
        'TimeUntil' => 'datetime:H:i',   // Stored as TIME, returned as Carbon
    ];

    protected $dates = [
        'deleted_at',
    ];

    // Announcement belongs to user (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
    }
}
