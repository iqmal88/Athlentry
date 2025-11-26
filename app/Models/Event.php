<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'EventID';
    public $timestamps = true;
    
    protected $fillable = [
        'EventName','Location','StartDate','EndDate','Description','CreatedBy','Status'
    ];
    
    protected $casts = [
    'StartDate' => 'date',
    'EndDate'   => 'date',
    ];

    public function games()
    {
        return $this->hasMany(\App\Models\GameInfo::class, 'EventID', 'EventID');
    }
}
