<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('GameInfo', function (Blueprint $table) {
            $table->id('GameID'); // PK
            $table->string('GameName', 255)->unique();
            $table->string('Category', 100);
            $table->text('Description')->nullable();
            $table->dateTime('GameTime');
            
            // FK to Announcement
            $table->unsignedBigInteger('AnnouncementID');
            $table->foreign('AnnouncementID')
                  ->references('AnnouncementID')
                  ->on('Announcement')
                  ->onDelete('cascade'); // Assuming deleting an announcement deletes the associated game info

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('GameInfo');
    }
};
