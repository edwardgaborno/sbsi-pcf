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
            $table->foreignId('source_id')
                ->nullable()
                ->constrained('sources')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('p_c_f_request_id')
                ->nullable()
                ->constrained('p_c_f_requests')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('sales', 11, 2)->default(0.00);
            $table->decimal('total_sales', 12, 2)->default(0.00);
            // $table->decimal('transfer_price', 11, 2)->default(0.00); // not being used; source id can be use to get required data in the future
            // $table->decimal('mandatory_peripherals', 11, 2)->default(0.00); // not being used; source id can be use to get required data in the future
            $table->decimal('opex', 11, 2)->default(0.00);
            $table->decimal('net_sales', 11, 2)->default(0.00);
            $table->decimal('gross_profit', 11, 2)->default(0.00);
            $table->decimal('total_gross_profit', 12, 2)->default(0.00);
            $table->decimal('total_net_sales', 12, 2)->default(0.00);
            $table->double('profit_rate', 11, 2)->default(0.00);
            $table->string('above_standard_price')->nullable();
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
