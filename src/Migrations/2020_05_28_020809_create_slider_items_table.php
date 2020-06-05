<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            ['slider_id','file_id','general_text','sub_text','sub_text2','status','order'];
            $table->id();
            $table->unsignedInteger('slider_id');
            $table->string('filepath');
            $table->string('general_text')->nullable();
            $table->string('sub_text')->nullable();;
            $table->string('sub_text2')->nullable();;
            $table->unsignedInteger('status');
            $table->unsignedInteger('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_items');
    }
}
