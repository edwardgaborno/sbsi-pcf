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
            $table->string('rfq_no');
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
            $table->decimal('opex', 11, 2)->default(0.00);
            $table->decimal('net_sales', 11, 2)->default(0.00);
            $table->decimal('gross_profit', 11, 2)->default(0.00);
            $table->decimal('total_gross_profit', 12, 2)->default(0.00);
            $table->decimal('total_net_sales', 12, 2)->default(0.00);
            $table->double('profit_rate', 11, 2)->default(0.00);
            $table->tinyInteger('is_bundled')->default(0);
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
