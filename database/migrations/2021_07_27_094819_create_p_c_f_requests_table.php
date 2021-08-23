<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pcf_no');
            $table->date('date');
            $table->string('institution');
            $table->string('duration');
            $table->date('date_biding');
            $table->double('bid_docs_price')->default(0.00);
            $table->string('psr');
            $table->string('manager');
            $table->double('profit', 11, 2)->default(0.00);
            $table->double('profit_rate', 11, 2)->default(0.00);
            $table->integer('status')->default(0);
            $table->integer('created_by');
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
        Schema::dropIfExists('p_c_f_requests');
    }
}
