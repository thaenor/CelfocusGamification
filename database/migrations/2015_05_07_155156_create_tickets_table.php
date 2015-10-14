<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tickets', function($table)
        {
            $table->string('title');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('tickets', function($table)
        {
            $table->dropColumn('title');
            $table->dropColumn('user_id');
        });

	}

}
