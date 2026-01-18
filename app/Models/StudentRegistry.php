<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistry extends Model
{
    use HasFactory;

    protected $table = 'student_registry';

    protected $fillable = [
        'MatricNo',
        'Name',
        'Email',
        'Department',
    ];

    /**
     * Find student by matric number and name
     */
    public static function findByMatricAndName($matricNo, $name)
    {
        return self::where('MatricNo', $matricNo)
                   ->where('Name', $name)
                   ->first();
    }

    /**
     * Check if matric number exists
     */
    public static function isValidMatric($matricNo)
    {
        return self::where('MatricNo', $matricNo)->exists();
    }
}
