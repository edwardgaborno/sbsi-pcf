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
            $table->string('serial_no');
            $table->string('type');
            $table->integer('quantity');
            $table->decimal('opex', 11, 2)->default(0.00);
            $table->decimal('total_cost', 11, 2)->default(0.00);
            $table->decimal('cost_year', 11, 2)->default(0.00);
            $table->tinyInteger('depreciable_life');
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
