<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // If your original table exists, you should write an "alter" migration instead of create.
        Schema::create('game_info', function (Blueprint $table) {
            $table->id('GameID');

            // link to events table (Event header)
            $table->unsignedBigInteger('EventID')->nullable();

            $table->string('GameName');
            $table->string('Category')->nullable();       // e.g. Team/Individual, Men/Women/Open
            $table->date('GameDate')->nullable();
            $table->time('GameTime')->nullable();
            $table->string('SelectionPlace')->nullable(); // venue
            $table->string('CoachName')->nullable();
            $table->string('CoachPhone')->nullable();
            $table->unsignedInteger('Capacity')->nullable(); // max participants
            $table->text('Rules')->nullable();
            $table->text('Description')->nullable();

            $table->enum('Status', ['Open','Closed','Cancelled'])->default('Open');

            $table->timestamps();

            // foreign keys
            $table->foreign('EventID')->references('EventID')->on('events')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_info');
    }
};
