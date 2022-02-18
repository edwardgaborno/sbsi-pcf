<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceMandatoryPeripheralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_mandatory_peripherals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')
                ->nullable()
                ->constrained('sources')
                ->onUpdate('cascade');
            $table->foreignId('mandatory_peripheral_id')
                ->nullable()
                ->constrained('mandatory_peripherals')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('source_mandatory_peripherals');
    }
}
