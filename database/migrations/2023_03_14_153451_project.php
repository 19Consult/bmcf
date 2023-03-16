<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Project extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_role');
            $table->string("name_project")->nullable();
            $table->string('photo_project')->nullable();
            $table->text("brief_description")->nullable();
            $table->string("keyword1")->nullable();
            $table->string("keyword2")->nullable();
            $table->string("keyword3")->nullable();
            $table->text("project_story")->nullable();
            $table->boolean('video_skip')->default(false);
            $table->string("youtube_link")->nullable();
            $table->string("vimeo_link")->nullable();
            $table->boolean('business_plan_skip')->default(false);
            $table->text("business_plan")->nullable();
            $table->text("co_founder_terms_condition")->nullable();
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
        Schema::dropIfExists('projects');
    }
}
