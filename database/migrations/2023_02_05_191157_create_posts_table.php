<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('user_id');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('topic')->nullable();
            $table->string('subject')->nullable();
            $table->string('specialized')->nullable();
            $table->string('school_year')->nullable();
            $table->string('category')->nullable();
            $table->longtext('content')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('daily_post')->default(0);
            $table->integer('story_post')->default(0);
            $table->integer('event_post')->default(0);
            $table->dateTime('end_time_event')->nullable();
            $table->string('image')->nullable();
            $table->integer('comment_mode')->default(0);
            $table->integer('like_count')->nullable();
            $table->integer('comment_count')->nullable();
            $table->integer('view_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
