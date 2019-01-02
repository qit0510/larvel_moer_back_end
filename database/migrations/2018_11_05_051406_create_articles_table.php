<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->default("");
            $table->text('content')->nullable();
            $table->string('mainPic')->nullable();
            $table->integer('column_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->unsignedInteger('up_votes_count')->default(0)->index()->comment('赞数量');
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
        Schema::dropIfExists('articles');
    }
}
