<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('bookable_id');
            $table->string('bookable_type');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->integer('price_paid');
            $table->timestamps();
        });
    }
};
