<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {

            $table->string('payment_reference')->nullable();

            $table->string('payment_status')
                ->default('pending');

            $table->string('payment_gateway')
                ->default('paystack');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {

            $table->dropColumn([
                'payment_reference',
                'payment_status',
                'payment_gateway',
            ]);
        });
    }
};