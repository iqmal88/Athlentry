<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('EventID');
            $table->string('EventName');
            $table->string('Location')->nullable();
            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('CreatedBy')->nullable(); // admin user id (optional)
            $table->enum('Status', ['Open','Closed','Cancelled'])->default('Open');
            $table->timestamps();

            // If your users table primary key is UserID uncomment and adapt:
            // $table->foreign('CreatedBy')->references('UserID')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
