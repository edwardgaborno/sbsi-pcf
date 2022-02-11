<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMandatoryPeripheralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandatory_peripherals', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('item_description');
            $table->integer('quantity');
            $table->foreignId('peripherals_category_id')
                ->nullable()
                ->constrained('mandatory_peripheral_categories')
                ->onUpdate('cascade');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('mandatory_peripherals');
    }
}
