<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCFInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_f_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('institution');
            $table->string('address');
            $table->string('contact_person');
            $table->string('designation');
            $table->string('thru_contact_person')->nullable(); 
            $table->string('thru_designation')->nullable(); 
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('telephone_number')->nullable();
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
        Schema::dropIfExists('p_c_f_institutions');
    }
}
