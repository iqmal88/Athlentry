<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('Password');
            $table->string('MatricNo')->nullable();
            $table->string('Role'); // admin, student
            $table->text('MedicalHistory')->nullable();
            $table->text('Achievement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
