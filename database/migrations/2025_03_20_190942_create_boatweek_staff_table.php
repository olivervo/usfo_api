<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boatweek_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->foreignId('boatweek_id')->constrained()->cascadeOnDelete();
            $table->string('role');
            $table->dateTime('reminder_sent')->nullable();
            $table->dateTime('status_updated_at')->nullable();
            $table->decimal('percent')->default(1);
            $table->integer('weekly_salary');
            $table->enum('status', ['confirmed', 'pending', 'declined'])->default('pending');
            $table->timestamps();
        });
    }
};
