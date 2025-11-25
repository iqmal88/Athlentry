<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('ApplicationID');

            // references (keep your naming)
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('GameID');
            $table->unsignedBigInteger('StatusID')->nullable();

            // student's submitted info
            $table->string('SportType')->nullable();
            $table->text('Achievement')->nullable();
            $table->text('MedicalHistory')->nullable();
            $table->dateTime('DateApplied')->useCurrent();

            // snapshot fields (preserve game/event info at time of application)
            $table->string('SnapshotEventName')->nullable();
            $table->string('SnapshotGameName')->nullable();
            $table->date('SnapshotGameDate')->nullable();
            $table->string('SnapshotLocation')->nullable();
            $table->unsignedInteger('SnapshotCapacity')->nullable();

            $table->timestamps();

            // foreign keys
            // adapt these references if your users PK is 'id' or 'UserID'
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
