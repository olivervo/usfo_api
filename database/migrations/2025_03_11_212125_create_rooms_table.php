<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('capacity');
            $table->integer('price_per_night');
            $table->json('amenities')->nullable();
            $table->foreignId('lodge_id')->constrained();
            $table->timestamps();
        });
    }
};
