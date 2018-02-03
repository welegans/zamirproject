<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
      $table->increments('id');
      $table->integer('user_id');
      $table->float('total');
      $table->string('address');
      // $table->string('size');
      $table->tinyInteger('paymentStatus');
      $table->string('transactionId')->nullable();
      $table->string('paymentRequestId')->nullable();
      $table->longText('paymentResponse')->nullable();
      $table->tinyInteger('delivered');
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
    Schema::dropIfExists('orders');
  }
}
