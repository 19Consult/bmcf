<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumdUserDetailInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_details', function (Blueprint $table) {
            $table->boolean('new_project_email')->default(false);
            $table->boolean('notification_email')->default(false);
            $table->boolean('nda_approved_email')->default(false);
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
            $table->dropColumn('new_project_email');
            $table->dropColumn('notification_email');
            $table->dropColumn('nda_approved_email');
        });
    }
}
