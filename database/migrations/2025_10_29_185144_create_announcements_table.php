<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('AnnouncementID');
            $table->string('Location')->nullable();
            $table->string('Title');
            $table->date('Date')->nullable();
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('CreatedBy');
            $table->timestamps();

            $table->foreign('CreatedBy')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
