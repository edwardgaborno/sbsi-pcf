<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductSegmentIdToPCFRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_c_f_requests', function (Blueprint $table) {
            $table->foreignId('product_segment_id') // institution_id
                ->after('institution_id')
                ->nullable()
                ->constrained('product_segments')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_c_f_requests', function (Blueprint $table) {
            //
        });
    }
}
