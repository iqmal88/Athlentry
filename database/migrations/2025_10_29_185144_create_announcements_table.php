<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('AnnouncementID');

            $table->string('Title');
            $table->string('Location')->nullable();
            $table->date('Date')->nullable();

            // Time columns (new)
            $table->time('TimeFrom')->nullable();
            $table->time('TimeUntil')->nullable();

            $table->text('Description')->nullable();

            // uploaded image (stored as filename or path)
            $table->string('Image')->nullable();

            // foreign key to users table
            $table->unsignedBigInteger('CreatedBy');
            $table->foreign('CreatedBy')
                  ->references('UserID')
                  ->on('users')
                  ->onDelete('cascade');

            // timestamps
            $table->timestamps();

            // recommended for admin deletion tracking
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
