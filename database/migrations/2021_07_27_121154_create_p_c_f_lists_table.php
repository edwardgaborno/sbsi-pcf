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
            $table->mediumInteger('quantity');
            $table->decimal('sales', 11, 2)->default(0.00);
            $table->decimal('total_sales', 14, 2)->default(0.00);
            $table->decimal('transfer_price', 12, 2)->nullable()->default(0.00);
            $table->decimal('mandatory_peripherals', 11, 2)->nullable()->default(0.00);
            $table->decimal('opex', 11, 2)->nullable()->default(0.00);
            $table->decimal('net_sales', 11, 2)->nullable()->default(0.00);
            $table->decimal('gross_profit', 12, 2)->nullable()->default(0.00);
            $table->decimal('total_gross_profit', 12, 2)->nullable()->default(0.00);
            $table->decimal('total_net_sales', 11, 2)->nullable()->default(0.00);
            $table->decimal('profit_rate', 11, 2)->nullable()->default(0.00);
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
