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
        Schema::create('buyings', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('desired_location1');
            $table->string('desired_location2')->nullable();
            $table->string('desired_location3')->nullable();
            $table->string('area');
            $table->json('images');
            $table->string('phone');
            $table->enum('status' , ['exchange' , 'sale' , 'both']);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyings');
    }
};
