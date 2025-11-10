<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('ApplicationID');
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('GameID');
            $table->unsignedBigInteger('StatusID')->nullable();
            $table->string('SportType');
            $table->text('Achievement')->nullable();
            $table->date('DateApplied')->useCurrent();
            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('GameID')->references('GameID')->on('game_info')->onDelete('cascade');
            $table->foreign('StatusID')->references('StatusID')->on('statuses')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
