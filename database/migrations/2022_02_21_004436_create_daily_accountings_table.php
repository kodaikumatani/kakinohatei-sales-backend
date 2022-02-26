<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DailyAccountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_accountings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('received_at');
            $table->unsignedSmallInteger('store_id');
            $table->unsignedSmallInteger('product_id');
            $table->unsignedSmallInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedSmallInteger('store_sum');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_accountings');
    }
}
