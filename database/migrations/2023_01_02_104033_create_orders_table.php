<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('order_number');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            // $table->string('country');

            $table->string('status');
            $table->string('payment_status');
            $table->string('payment_method');
            // $table->string('payment_id');
            // $table->string('payment_url');
            $table->string('payment_amount');
            // $table->string('payment_currency');
            // $table->string('payment_description');
            // $table->string('payment_created_at');
            // $table->string('payment_paid_at');
            // $table->string('payment_expired_at');
            // $table->string('payment_failed_at');
            // $table->string('payment_canceled_at');
            // $table->string('payment_refunded_at');
            // $table->string('payment_provider');
            // $table->string('payment_provider_id');
            // $table->string('payment_provider_status');
            // $table->string('payment_provider_response');

            $table->timestamps();
        });
    }
};
