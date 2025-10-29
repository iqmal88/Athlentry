<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Application', function (Blueprint $table) {
            $table->id('ApplicationID'); // PK

            // FKs
            // $table->foreignId() is a shorthand for unsignedBigInteger + foreign constraint
            $table->foreignId('UserID')->constrained('User', 'UserID')->onDelete('cascade');
            $table->foreignId('GameID')->constrained('GameInfo', 'GameID')->onDelete('cascade');
            
            // StatusID is an INTEGER PK, so we use integer and then set the constraint
            $table->integer('StatusID')->unsigned();
            $table->foreign('StatusID')->references('StatusID')->on('Status')->onDelete('restrict'); 

            // Other columns
            $table->string('SportType', 100);
            $table->date('DateApplied');
            $table->text('Achievement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Application');
    }
};
