<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueInProjectParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_participants', function (Blueprint $table) {
            $table->dropColumn(['pvcot', 'raci']);
        });

        Schema::table('project_participants', function (Blueprint $table) {
            $table->string('pvcot', 25)->default('client')->after('id');
            $table->string('raci', 25)->default('a')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_participants', function (Blueprint $table) {
            $table->dropColumn(['pvcot', 'raci']);
        });

        Schema::table('project_participants', function (Blueprint $table) {
            $table->string('pvcot', 25)->default('')->after('id');
            $table->string('raci', 25)->default('')->after('id');
        });
    }
}
