<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('track_update', function (Blueprint $table) {
            $table->id();
            $table->string('track_num');
            $table->string('status');
            $table->string('date');
            $table->string('time');
            $table->string('note');
            $table->string('current_location');
            $table->string('invoice_sub_total');
            $table->string('discount');
            $table->string('tax');
            $table->string('invoice_total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('track_update');
    }
};
