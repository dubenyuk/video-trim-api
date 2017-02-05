<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('path');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('video_statuses');
        });

        DB::table('videos')->insert([
                [
                    'user_id' => 1,
                    'status_id' => 1,
                    'path' => public_path().'/video/1.flv',
                ],
                [
                    'user_id' => 1,
                    'status_id' => 2,
                    'path' => public_path().'/video/2.flv',
                ],
                [
                    'user_id' => 1,
                    'status_id' => 3,
                    'path' => public_path().'/video/3.flv',
                ],
                [
                    'user_id' => 1,
                    'status_id' => 4,
                    'path' => public_path().'/video/4.flv',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
