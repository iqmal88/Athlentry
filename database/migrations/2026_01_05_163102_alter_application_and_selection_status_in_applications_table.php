<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        /**
         * STEP 1️⃣ EXPAND & RELAX SelectionStatus
         * - Benarkan NULL
         * - Tambah in_selection
         */
        DB::statement("
            ALTER TABLE applications
            MODIFY SelectionStatus
            ENUM('pending','in_selection','selected','rejected')
            NULL
        ");

        /**
         * STEP 2️⃣ MIGRATE DATA (Selection)
         * pending → NULL
         */
        DB::statement("
            UPDATE applications
            SET SelectionStatus = NULL
            WHERE SelectionStatus = 'pending'
        ");

        /**
         * STEP 3️⃣ FINALIZE SelectionStatus ENUM (CLEAN)
         */
        DB::statement("
            ALTER TABLE applications
            MODIFY SelectionStatus
            ENUM('in_selection','selected','rejected')
            NULL
        ");

        /**
         * STEP 4️⃣ EXPAND ApplicationStatus
         */
        DB::statement("
            ALTER TABLE applications
            MODIFY ApplicationStatus
            ENUM('submitted','pending','approved','rejected','withdrawn')
            NOT NULL
            DEFAULT 'submitted'
        ");

        /**
         * STEP 5️⃣ MIGRATE DATA (Application)
         * submitted → pending
         */
        DB::statement("
            UPDATE applications
            SET ApplicationStatus = 'pending'
            WHERE ApplicationStatus = 'submitted'
        ");

        /**
         * STEP 6️⃣ FINALIZE ApplicationStatus ENUM
         */
        DB::statement("
            ALTER TABLE applications
            MODIFY ApplicationStatus
            ENUM('pending','approved','rejected','withdrawn')
            NOT NULL
            DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        /**
         * ROLLBACK KE STRUKTUR LAMA
         */
        DB::statement("
            ALTER TABLE applications
            MODIFY ApplicationStatus
            ENUM('submitted','withdrawn')
            NOT NULL
            DEFAULT 'submitted'
        ");

        DB::statement("
            ALTER TABLE applications
            MODIFY SelectionStatus
            ENUM('pending','selected','rejected')
            NOT NULL
            DEFAULT 'pending'
        ");
    }
};
