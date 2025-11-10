<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_info', function (Blueprint $table) {
            $table->id('GameID');
            $table->string('GameName');
            $table->string('Category');
            $table->date('GameDate');
            $table->time('GameTime')->nullable();
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('AnnouncementID')->nullable();
            $table->timestamps();

            $table->foreign('AnnouncementID')->references('AnnouncementID')->on('announcements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_info');
    }
};
