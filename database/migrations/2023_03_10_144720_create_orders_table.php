<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_variants_id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('total');
            $table->boolean('status');
            $table->boolean('payment_method');
            $table->string('code');
            $table->timestamps();
            $table->foreign('customer_variants_id')
                ->references('id')
                ->on('customer_variants')
                ->cascadeOnDelete();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
