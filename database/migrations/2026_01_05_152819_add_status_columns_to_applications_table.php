<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {

            // 🧑‍🎓 Status untuk flow application (student/system)
            $table->enum('ApplicationStatus', [
                'submitted',
                'withdrawn'
            ])->default('submitted')
              ->after('StatusID');

            // 👨‍💼 Status untuk selection (admin)
            $table->enum('SelectionStatus', [
                'pending',
                'selected',
                'rejected'
            ])->default('pending')
              ->after('ApplicationStatus');

            // OPTIONAL: buang FK StatusID (tak delete column)
            $table->dropForeign(['StatusID']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {

            $table->dropColumn([
                'ApplicationStatus',
                'SelectionStatus'
            ]);

            // restore FK jika perlu rollback
            $table->foreign('StatusID')
                  ->references('StatusID')
                  ->on('statuses')
                  ->onDelete('set null');
        });
    }
};
