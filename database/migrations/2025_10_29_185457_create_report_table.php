<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Report', function (Blueprint $table) {
            $table->id('ReportID'); // PK
            $table->text('Content');
            $table->date('CreatedDate');

            // FKs
            $table->foreignId('UserID')->constrained('User', 'UserID')->onDelete('cascade');
            $table->foreignId('ApplicationID')->constrained('Application', 'ApplicationID')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Report');
    }
};
