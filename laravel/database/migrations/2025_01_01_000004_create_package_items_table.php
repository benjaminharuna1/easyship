<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id');
            $table->integer('quantity');
            $table->string('piece_type');
            $table->string('description');
            $table->decimal('length', 10, 2)->default(0);
            $table->decimal('width', 10, 2)->default(0);
            $table->decimal('height', 10, 2)->default(0);
            $table->decimal('weight', 10, 2)->default(0);
            $table->timestamps();

            $table->index('tracking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_items');
    }
};
