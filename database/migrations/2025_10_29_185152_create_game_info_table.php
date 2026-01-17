<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_info', function (Blueprint $table) {
            $table->id('GameID');

            $table->unsignedBigInteger('EventID');
            $table->string('GameName');
            $table->string('Category');
            $table->date('GameDate');
            $table->time('TimeStart');
            $table->time('TimeEnd');
            $table->string('SelectionPlace')->nullable();
            $table->string('CoachName')->nullable();
            $table->string('CoachPhone')->nullable();
            $table->integer('Capacity')->nullable();
            $table->text('Rules')->nullable();
            $table->text('Description')->nullable();
            $table->string('Status')->default('Open');

            $table->timestamps();

            $table->foreign('EventID')
                ->references('EventID')
                ->on('events')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_info');
    }
};
