<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'UserID';

    protected $fillable = [
        'Name',
        'MatricNo',
        'Email',
        'Password',
        'Role',
        'PhoneNumber',
        'MedicalHistory',
        'Achievement',
        'ProfilePhoto',
        'ProfileCompleted',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Calculate profile completion percentage and status
     */
    public function getCompletionStatus(): array
    {
        $requiredFields = [
            'PhoneNumber'    => $this->PhoneNumber,
            'MedicalHistory' => $this->MedicalHistory,
            'Achievement'    => $this->Achievement,
            'ProfilePhoto'   => $this->ProfilePhoto,
        ];

        $total = count($requiredFields);
        $filled = 0;

        foreach ($requiredFields as $value) {
            if (!empty($value)) {
                $filled++;
            }
        }

        $percentage = ($total > 0) ? (int)(($filled / $total) * 100) : 0;

        return [
            'percentage'  => $percentage,
            'is_complete' => $percentage === 100,
            'filled'      => $filled,
            'total'       => $total
        ];
    }

    /* =========================
     | ROLE HELPERS (OPTIONAL)
     ========================= */
    public function isStudent(): bool
    {
        return $this->Role === 'student';
    }

    public function isAdmin(): bool
    {
        return $this->Role === 'admin';
    }
}