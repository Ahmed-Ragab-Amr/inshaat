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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('alhy');
            $table->string('area');
            $table->string('style');
            $table->string('finish_level');
            $table->string('house_shape');
            $table->string('design');
            $table->integer('floor_number');
            $table->integer('sitting_number');
            $table->integer('kitchen_number');
            $table->integer('dining_room');
            $table->integer('guest_bedroom');
            $table->integer('other_room');
            $table->integer('bedroom_number');
            $table->integer('parking_number');
            $table->string('other_addition');
            $table->text('notes');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
