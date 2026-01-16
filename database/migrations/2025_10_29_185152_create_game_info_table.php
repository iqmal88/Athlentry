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
            $table->time('GameTime');
            $table->string('SelectionPlace');
            $table->string('CoachName');
            $table->string('CoachPhone');
            $table->integer('Capacity');
            $table->text('Rules');
            $table->text('Description');
            $table->string('Status');

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
