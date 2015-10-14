<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketTableAgain extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tickets', function($table)
        {
            $table->dropColumn('assignedGroup');
            $table->integer('assignedGroup_id')->unisnged();
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
            $table->dropColumn('assignedGroup_id');
        });
	}

}
