<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('ReportID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('ApplicationID');

            $table->text('Content');
            $table->date('CreatedDate');

            $table->timestamps();

            $table->foreign('UserID')
                ->references('UserID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('ApplicationID')
                ->references('ApplicationID')
                ->on('applications')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
