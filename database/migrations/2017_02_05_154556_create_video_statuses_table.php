<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVideoStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_statuses',function(Blueprint $table){
            $table->increments('id');
            $table->string('status')->unique();
        });

        DB::table('video_statuses')->insert([
                [
                    'status' => 'done',
                ],
                [
                    'status' => 'failed',
                ],
                [
                    'status' => 'scheduled',
                ],
                [
                    'status' => 'processing',
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
        Schema::dropIfExists('video_statuses');
    }
}
