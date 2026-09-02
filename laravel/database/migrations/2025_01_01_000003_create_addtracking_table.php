<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addtracking', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->string('sender_name');
            $table->string('sender_contact');
            $table->string('sender_email');
            $table->string('sender_address');
            $table->string('status')->default('Pending');
            $table->string('dispatch_location');
            $table->string('carrier');
            $table->string('carrier_refrence_number');
            $table->string('weight');
            $table->string('payment_mode');
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->string('image')->default('');
            $table->string('receiver_name');
            $table->string('receiver_contact');
            $table->string('receiver_email');
            $table->string('receiver_address');
            $table->string('destination');
            $table->string('package_discription');
            $table->date('dispatch_date');
            $table->date('estimated_delivery_date');
            $table->string('shipment_mode');
            $table->string('quantity');
            $table->text('message')->nullable();
            $table->string('current_location')->nullable();
            $table->text('delivery_message')->nullable();
            $table->string('date_added');
            $table->text('remarks')->nullable();
            $table->decimal('total_freight', 10, 2)->nullable();
            $table->string('courier')->nullable();
            $table->string('origin')->nullable();
            $table->time('departure_time')->nullable();
            $table->date('pickup_date')->nullable();
            $table->time('pickup_time')->nullable();
            $table->text('comments')->nullable();
            $table->dateTime('datetimepicker')->nullable();
            $table->string('type_of_shipment')->nullable();
            $table->decimal('total_volumetric_weight', 10, 2)->nullable();
            $table->decimal('total_actual_weight', 10, 2)->nullable();
            $table->boolean('published')->default(false);
            $table->json('coordinates')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addtracking');
    }
};
