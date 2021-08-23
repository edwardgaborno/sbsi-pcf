<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFInclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_inclusions', function (Blueprint $table) {
            $table->id();
            $table->string('pcf_no');
            $table->string('item_code');
            $table->string('description');
            $table->string('serial_no');
            $table->string('type');
            $table->integer('quantity');
            $table->double('mandatory_peripherals', 11, 2)->default(0.00);
            $table->double('opex', 11, 2)->default(0.00);
            $table->double('total_cost', 11, 2)->default(0.00);
            $table->double('depreciable_life', 11, 2)->default(0.00);
            $table->double('cost_year', 11, 2)->default(0.00);
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
        Schema::dropIfExists('p_c_f_inclusions');
    }
}
