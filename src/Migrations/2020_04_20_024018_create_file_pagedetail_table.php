<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePagedetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_page_detail', function (Blueprint $table) {
            $table->unsignedInteger('file_id');
//            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedInteger('page_detail_id');
//            $table->foreign('page_detail_id')->references('id')->on('page_details')->onDelete('cascade');
            $table->string('key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_pagedetail');
    }
}
