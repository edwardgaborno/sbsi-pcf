<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->onUpdate('cascade');
            $table->string('item_code');
            $table->string('description');
            $table->decimal('unit_price', 11, 2);
            $table->decimal('currency_rate');
            $table->decimal('tp_php', 12, 2);
            $table->decimal('tp_php_less_tax', 12, 2);
            $table->foreignId('uom_id')
                ->nullable()
                ->constrained('unit_of_measurements')
                ->onUpdate('cascade');
            // $table->string('mandatory_peripherals')->nullable();
            $table->decimal('cost_of_peripherals', 11, 2)->nullable();
            $table->foreignId('segment_id')
            ->nullable()
            ->constrained('segments')
            ->onUpdate('cascade');
            $table->foreignId('item_category_id')
                ->nullable()
                ->constrained('item_categories')
                ->onUpdate('cascade');
            $table->decimal('standard_price', 11, 2);
            $table->string('profitability');
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
        Schema::dropIfExists('sources');
    }
}
