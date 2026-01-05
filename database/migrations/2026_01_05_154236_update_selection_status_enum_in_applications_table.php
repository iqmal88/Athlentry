<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE applications
            MODIFY SelectionStatus
            ENUM('pending', 'selected', 'rejected')
            NOT NULL
            DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE applications
            MODIFY SelectionStatus
            ENUM('pending', 'approved', 'rejected')
            NOT NULL
            DEFAULT 'pending'
        ");
    }
};
