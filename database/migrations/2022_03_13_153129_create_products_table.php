<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('category_id');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->string('meta_description');

            $table->string('slug');
            $table->string('name');
            $table->mediumText('description')->nullable();

            $table->string('brand');
            $table->string('selling_price');
            $table->string('original_price');
            $table->string('qt');
            $table->string('image')->nullable();
            
            $table->tinyInteger('feature')->default('0')->nullable();
            $table->tinyInteger('popular')->default('0')->nullable();
            $table->tinyInteger('status')->default('0')->nullable();
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