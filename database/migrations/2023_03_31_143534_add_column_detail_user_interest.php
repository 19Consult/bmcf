<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDetailUserInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_details', function (Blueprint $table) {
            $table->string('basic_interests_investor')->nullable();
            $table->string('categorty1_investor')->nullable();
            $table->string('categorty2_investor')->nullable();
            $table->string('categorty3_investor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_details', function (Blueprint $table) {
            $table->dropColumn('basic_interests_investor');
            $table->dropColumn('categorty1_investor');
            $table->dropColumn('categorty2_investor');
            $table->dropColumn('categorty3_investor');
        });
    }
}
