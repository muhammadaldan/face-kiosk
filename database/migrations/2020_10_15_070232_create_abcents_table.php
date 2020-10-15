<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbcentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abcents', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('employee_id')->unsigned();            
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');            
            $table->boolean('late')->comment('0 Late 1 On time');
            $table->timestamp('arrival')->nullable();
            $table->timestamp('waktu_pulang')->nullable();
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
        Schema::dropIfExists('abcents');
    }
}
