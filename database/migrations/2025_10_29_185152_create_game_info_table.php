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

            $table->string('GameName', 255);
            $table->string('Category', 255);

            $table->date('GameDate');
            $table->time('TimeStart');
            $table->time('TimeEnd');

            $table->string('GameVenue', 255)->nullable();

            $table->string('PICName', 255)->nullable();
            $table->string('PICPhone', 255)->nullable();

            $table->integer('Capacity')->nullable();

            $table->text('Rules')->nullable();
            $table->text('Description')->nullable();

            $table->string('Status', 255)->default('Open');

            $table->timestamps();

            // Foreign key
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
