<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interested', function (Blueprint $table) {
            $table->increments('interested_id')->first();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products');

            $table->string('interested_name');
            $table->string('interested_email');
            $table->boolean('interested_sent')->default(false);
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
        Schema::dropIfExists('interesteds');
    }
}
