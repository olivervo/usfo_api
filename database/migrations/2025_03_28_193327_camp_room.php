<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camp_room', function (Blueprint $table) {
            $table->foreignId('camp_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->enum('type', ['students', 'staff']);
            $table->timestamps();
        });
    }
};
