<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaySettingsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->index(); // e.g., paymongo
            $table->enum('mode', ['test', 'live'])->default('test');
            $table->text('live_key')->nullable();
            $table->text('test_key')->nullable();
            $table->text('live_webhook_secret')->nullable();
            $table->text('test_webhook_secret')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_gateway_settings');
    }
}
