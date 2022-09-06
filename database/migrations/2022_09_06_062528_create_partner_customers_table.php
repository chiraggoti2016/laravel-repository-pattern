<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('customer id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('partner_id')->comment('partner id');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_customers');
    }
}
