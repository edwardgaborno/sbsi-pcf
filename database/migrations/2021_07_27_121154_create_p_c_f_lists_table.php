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
            $table->integer('quantity');
            $table->decimal('sales', 11, 2)->default(0.00);
            $table->decimal('total_sales', 12, 2)->default(0.00);
            $table->decimal('transfer_price', 11, 2)->default(0.00);
            $table->decimal('mandatory_peripherals', 11, 2)->default(0.00);
            $table->decimal('opex', 11, 2)->default(0.00);
            $table->decimal('net_sales', 11, 2)->default(0.00);
            $table->decimal('gross_profit', 11, 2)->default(0.00);
            $table->decimal('total_gross_profit', 12, 2)->default(0.00);
            $table->decimal('total_net_sales', 12, 2)->default(0.00);
            $table->double('profit_rate', 11, 2)->default(0.00);
            $table->enum('above_standard_price', ['yes', 'no'])->nullable();
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
