<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNdaProjectOwner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nda_project', function (Blueprint $table) {
            $table->text('signature_owner')->nullable();
            $table->dateTime('data_signature_owner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nda_project', function (Blueprint $table) {
            $table->dropColumn('signature_owner');
            $table->dropColumn('data_signature_owner');
        });
    }
}
