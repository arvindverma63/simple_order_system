<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterNameColumnInUsersTable extends Migration
{
    public function up()
    {
        // Check manually before running this
        Schema::table('users', function (Blueprint $table) {
            // Modify name column length if needed (optional)
            $table->string('name', 255)->change();

            // Only drop if you confirmed the index exists
            // $table->dropUnique('users_name_unique');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only re-add if it was previously unique
            // $table->unique('name');
        });
    }
}
