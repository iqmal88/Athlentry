<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Announcement', function (Blueprint $table) {
            $table->id('AnnouncementID'); // PK
            $table->string('Location', 255);
            $table->string('Title', 255);
            $table->date('Date');
            $table->text('Description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Announcement');
    }
};
