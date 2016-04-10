<?php

use Illuminate\Database\Migrations\Migration;
use \jlourenco\support\Database\Blueprint;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('BlogCategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('description', 250);

            $table->timestamps();
            $table->softDeletes();
            $table->creation();
        });

        Schema::table('BlogCategory', function (Blueprint $table) {
            $table->creationRelation();
        });

        Schema::create('BlogPost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('slug', 100);
            $table->text('contents');
            $table->integer('category')->unsigned();
            $table->integer('author')->unsigned();
            $table->integer('likes')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('views')->default(0);
            $table->string('keywords', 250);

            $table->timestamps();
            $table->softDeletes();
            $table->creation();

            $table->foreign('category')->references('id')->on('BlogCategory');
            $table->foreign('author')->references('id')->on('User');
        });

        Schema::table('BlogPost', function (Blueprint $table) {
            $table->creationRelation();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('BlogPost');
        Schema::drop('BlogCategory');

    }
}
