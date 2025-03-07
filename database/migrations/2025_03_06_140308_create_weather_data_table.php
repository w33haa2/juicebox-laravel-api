<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->integer('weather_id'); // "id": 800
            $table->string('main');        // "main": "Clear"
            $table->string('description'); // "description": "clear sky"
            $table->string('icon');        // "icon": "01n"
            $table->timestamp('dt')->nullable(); // "dt": 1741273205 (timestamp)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
