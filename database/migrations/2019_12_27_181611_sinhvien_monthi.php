<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SinhvienMonthi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhvien_monthi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('studentId');
            $table->bigInteger('monthiId');
            $table->boolean('eligible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinhvien_monthi');
    }
}
