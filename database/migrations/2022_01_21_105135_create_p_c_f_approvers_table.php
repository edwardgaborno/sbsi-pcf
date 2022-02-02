<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p_c_f_request_id')
                ->nullable()
                ->constrained('p_c_f_requests')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('approval_status')
                ->default(null)
                ->nullable();
            $table->foreignId('done_by') // user_id
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('p_c_f_approvers');
    }
}
