<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('User', function (Blueprint $table) {
            // Standard Laravel user fields:
            $table->id('UserID'); // PK - equivalent to Laravel's $table->id();
            $table->string('Name', 255);
            $table->string('Email', 255)->unique();
            $table->string('Password', 255);

            // Custom fields from your ERD:
            $table->string('MatricNo', 50)->nullable();
            $table->string('PhoneNumber', 20)->nullable();
            $table->text('MedicalHistory')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('User');
    }
};
