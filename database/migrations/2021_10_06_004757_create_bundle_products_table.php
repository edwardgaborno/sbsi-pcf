<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p_c_f_list_id')
                ->nullable()
                ->constrained('p_c_f_lists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('p_c_f_inclusion_id')
                ->nullable()
                ->constrained('p_c_f_inclusions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('source_id')
                ->nullable()
                ->constrained('sources')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('unit_price')->nullable()->default(0);
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
        Schema::dropIfExists('bundle_products');
    }
}
