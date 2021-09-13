<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_lists', function (Blueprint $table) {
            $table->id();
            $table->string('pcf_no');
            $table->string('item_code');
            $table->string('description');
            $table->integer('quantity');
            $table->double('sales', 11, 2)->default(0.00);
            $table->double('total_sales', 11, 2)->default(0.00);
            $table->double('transfer_price', 11, 2)->default(0.00);
            $table->double('mandatory_peripherals', 11, 2)->default(0.00);
            $table->double('opex', 11, 2)->default(0.00);
            $table->double('net_sales', 11, 2)->default(0.00);
            $table->double('gross_profit', 11, 2)->default(0.00);
            $table->double('total_gross_profit', 11, 2)->default(0.00);
            $table->double('total_net_sales', 11, 2)->default(0.00);
            $table->double('profit_rate', 11, 2)->default(0.00);
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
        Schema::dropIfExists('p_c_f_lists');
    }
}
