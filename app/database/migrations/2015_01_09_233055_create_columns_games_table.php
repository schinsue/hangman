<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('games'))
		{
		    Schema::table('games', function($table)
			{
			    $table->string('word')->nullable();
			 	$table->string('solution')->nullable();
				$table->integer('tries_left')->nullable();
				$table->string('status')->nullable();
				$table->nullableTimestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('games', function($table)
		{
		    $table->dropColumn(array('created_at', 'updated_at', 'word', 'solution', 'tries_left', 'status'));
		});
	}

}
