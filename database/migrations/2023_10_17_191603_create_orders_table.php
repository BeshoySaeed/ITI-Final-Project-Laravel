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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['cart','processing','on-deliver', 'done'])->default("cart");
            $table->string('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('confirm_instructions')->nullable();
            $table->string("street")->nullable();
            $table->string("area")->nullable();
            $table->string("city")->nullable();
            $table->string("building_name")->nullable();
            $table->string("floor_number")->nullable();
            $table->string("flat_number")->nullable();
            $table->string("GPS_location")->nullable();
            $table->string("phone1")->nullable();
            $table->string("phone2")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
