<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizeProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('size_products', function (Blueprint $table) {
      $table->integer('product_id')->unsigned()->index();
      $table->integer('size_id')->unsigned()->index();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
    Schema::dropIfExists('size_products');
  }
}
