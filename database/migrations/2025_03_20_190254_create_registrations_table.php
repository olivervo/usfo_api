<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->string('zipcode');
            $table->string('city');
            $table->string('country');
            $table->date('date_of_birth')->nullable();
            $table->text('allergies')->nullable();
            $table->string('dietary_restrictions')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamp('invoice_sent_at')->nullable();
            $table->timestamp('paid_complete')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }
};
