<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('supplier')->nullable();
            $table->string('item_code')->nullable();
            $table->string('description')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('tp_php')->nullable();
            $table->string('item_group')->nullable();
            $table->string('uom')->nullable();
            $table->string('mandatory_peripherals')->nullable();
            $table->string('cost_periph')->nullable();
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
        Schema::dropIfExists('sources');
    }
}
