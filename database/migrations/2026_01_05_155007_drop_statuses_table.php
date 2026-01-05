<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('statuses');
    }

    public function down(): void
    {
        Schema::create('statuses', function ($table) {
            $table->id('StatusID');
            $table->string('StatusName');
            $table->timestamps();
        });
    }
};
