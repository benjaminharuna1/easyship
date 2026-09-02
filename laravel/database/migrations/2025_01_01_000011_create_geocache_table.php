<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geocache', function (Blueprint $table) {
            $table->id();
            $table->string('place')->unique();
            $table->string('lat');
            $table->string('lon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geocache');
    }
};
