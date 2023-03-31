<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NdaProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nda_project', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('id_project');
            $table->text('signature')->nullable();
            $table->string('date')->nullable();
            $table->string('disclosing')->nullable();
            $table->string('disclosing_mail')->nullable();
            $table->string('receiving')->nullable();
            $table->string('receiving_mail')->nullable();

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
        Schema::dropIfExists('nda_project');
    }
}
