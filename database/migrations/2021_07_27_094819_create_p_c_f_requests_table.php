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
            // decimal are great for storing prices, money; stores exact value
            $table->decimal('bid_docs_price')->default(0.00);
            $table->string('psr'); // we'll get the name of the PSR by using the column created by;
            $table->string('manager');
            $table->decimal('profit', 12, 2)->default(0.00);
            $table->decimal('profit_rate', 12, 2)->default(0.00);
            $table->tinyInteger('status')->default(0);
            // $table->integer('created_by');
            $table->foreignId('created_by') // user_id
                ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('p_c_f_requests');
    }
}
