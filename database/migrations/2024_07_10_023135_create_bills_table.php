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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',15);
            $table->text('address');
            $table->string('phone', 10);
            $table->string('email', 50);
            $table->tinyInteger('delivery_method');
            $table->tinyInteger('payment_method');
            $table->integer('point')->nullable();
            $table->integer('total_amount');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
