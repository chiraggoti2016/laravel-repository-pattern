<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdInCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('added_by')->comment('user id')->after('id');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
            $table->dropColumn(['added_by']);
        });
        Schema::enableForeignKeyConstraints();
    }
}
