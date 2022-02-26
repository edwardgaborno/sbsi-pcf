<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFRequestMandatoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_request_mandatory_items', function (Blueprint $table) {
            $table->id();
            $table->string('pcf_no');
            $table->foreignId('pcf_request_id')
                ->nullable()
                ->constrained('p_c_f_requests')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('mandatory_peripheral_id')
                ->nullable()
                ->constrained('mandatory_peripherals')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('p_c_f_lists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('p_c_f_request_mandatory_items');
    }
}
