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
            $table->unsignedBigInteger('EventID');
            $table->unsignedBigInteger('GameID');

            $table->string('ApplicationStatus');
            $table->string('SelectionStatus');
            $table->string('SportType');
            $table->date('DateApplied');

            // Snapshot fields
            $table->string('SnapshotEventName');
            $table->string('SnapshotGameName');
            $table->date('SnapshotGameDate');
            $table->string('SnapshotLocation');
            $table->integer('SnapshotCapacity');

            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('EventID')->references('EventID')->on('events')->onDelete('cascade');
            $table->foreign('GameID')->references('GameID')->on('game_info')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
