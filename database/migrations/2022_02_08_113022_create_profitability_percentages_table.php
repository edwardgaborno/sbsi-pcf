<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitabilityPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profitability_percentages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_category_id')
                ->nullable()
                ->constrained('item_categories')
                ->onUpdate('cascade');
            $table->decimal('percentage', 12,2);
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
        Schema::dropIfExists('profitability_percentages');
    }
}
