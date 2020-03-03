<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHadistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hadists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->text('bunyi');
            $table->integer('kategori')->unsigned();
            $table->integer('sumber')->unsigned();
            $table->timestamps();

            $table->foreign('kategori')->references('id')->on('kategories')->onDelete('cascade');
            $table->foreign('sumber')->references('id')->on('sumber')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hadists');
    }
}
