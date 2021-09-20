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
            $table->string('address');
            $table->string('contact_person');
            $table->string('designation');
            $table->string('thru_designation'); 
            $table->string('supplier');
            $table->string('terms');
            $table->string('validity');
            $table->string('delivery');
            $table->string('warranty')->nullable();
            $table->string('contract_duration');
            $table->date('date_bidding');
            $table->decimal('bid_docs_price')->default(0.00);
            $table->string('psr'); // we can get the name of the PSR by using the column created by;
            $table->string('manager');
            $table->decimal('annual_profit', 12, 2)->default(0.00);
            $table->decimal('annual_profit_rate');
            $table->tinyInteger('status')->default(0);
            $table->string('pcf_document')->nullable();
            $table->foreignId('created_by') // user_id
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('disapproved_by')
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
