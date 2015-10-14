<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table)
        {
            $table->string('full_name');
            $table->integer('points')->default(0);
            $table->integer('health_points')->default(100);
            $table->integer('experience')->default(0);
            $table->integer('level')->default(1);
            $table->integer('league_id')->unsigned();

            $table->foreign('league_id')->references('id')->on('leagues');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
        {
            $table->dropColumn('full_name');
            $table->dropColumn('points');
            $table->dropColumn('health_points');
            $table->dropColumn('experience');
            $table->dropColumn('level');
            $table->dropColumn('league_id');
        });
	}

}
