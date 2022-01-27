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
            $table->string('rfq_no');
            $table->foreignId('institution_id') // institution_id
                ->nullable()
                ->constrained('p_c_f_institutions')
                ->onUpdate('cascade');
            $table->string('supplier');
            $table->string('terms');
            $table->string('validity');
            $table->string('delivery');
            $table->string('warranty')->nullable();
            $table->string('contract_duration');
            $table->date('date_bidding')->nullable();
            $table->decimal('bid_docs_price')->nullable();
            $table->boolean('is_psr_manager_approved')->nullable();
            $table->boolean('is_marketing_approved')->nullable();
            $table->boolean('is_accounting_approved')->nullable();
            $table->boolean('is_nsm_approved')->nullable();
            $table->boolean('is_cfo_approved')->nullable();
            $table->string('manager');
            $table->decimal('annual_profit', 12, 2)->default(0.00);
            $table->decimal('annual_profit_rate');
            $table->string('pcf_document')->nullable();
            $table->foreignId('created_by') // user_id
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade');
            $table->foreignId('updated_by') // user_id
                ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('p_c_f_requests');
    }
}
