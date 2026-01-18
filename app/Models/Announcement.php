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
        'DateClose',
        'TimeClose',
        'Description',
        'Image',
        'CreatedBy',
    ];

    protected $casts = [
        'DateClose' => 'date',
        'TimeClose' => 'datetime:H:i:s',
    ];

    // Announcement belongs to user (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
    }
}
