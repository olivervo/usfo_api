<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->foreignId('user_id');
            $table->integer('amount');
            $table->string('stripe_checkout_session_id')->nullable();
            $table->string('stripe_payment_intent');
            $table->enum('status', ['pending', 'paid', 'refunded', 'partially_refunded'])->default('pending');
            $table->date('paid_at');
            $table->timestamps();
        });
    }
};
