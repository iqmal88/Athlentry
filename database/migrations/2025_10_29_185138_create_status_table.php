<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Status', function (Blueprint $table) {
            $table->integer('StatusID')->primary(); // PK
            $table->string('StatusName', 50)->unique();
            $table->string('Selection', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Status');
    }
};
