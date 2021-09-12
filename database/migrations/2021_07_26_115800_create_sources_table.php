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
            $table->decimal('unit_price', 11, 2)->nullable();
            $table->decimal('currency_rate')->nullable();
            $table->decimal('tp_php', 12, 2)->nullable();
            $table->string('item_group')->nullable();
            $table->string('uom')->nullable();
            $table->string('mandatory_peripherals')->nullable();
            $table->decimal('cost_of_peripherals', 11, 2)->nullable()->default(0.00);
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
