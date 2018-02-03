<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->string('subtitle');
      $table->string('description');
      $table->string('brand');
      $table->string('gender');
      $table->string('oldprice');
      $table->string('price');
      $table->string('image');
      // $table->integer('posted_by')->nullable();
      $table->boolean('status')->nullable();
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
    Schema::dropIfExists('products');
  }
}
