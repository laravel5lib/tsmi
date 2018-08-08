<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusForSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->string('status')->nullable()->after('host');
            $table->string('status_last_update')->nullable()->after('status');
            $table->timestamp('last_update')->nullable()->after('status_last_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_last_update');
            $table->dropColumn('last_update');
        });
    }
}
