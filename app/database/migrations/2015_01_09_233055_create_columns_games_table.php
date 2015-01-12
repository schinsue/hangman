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
				// Putting defaults for everything so it's easily testable if something goes wrong.
			    $table->string('word')->nullable();
			 	$table->string('solution')->nullable();
				$table->integer('tries_left')->default(11);
				$table->string('status')->default('busy');
				
				// Laravel automatically handles timestamps so it won't ever be null =)
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
		if (Schema::hasTable('games'))
		{
			Schema::table('games', function($table)
			{
			    $table->dropColumn(array('created_at', 'updated_at', 'word', 'solution', 'tries_left', 'status'));
			});
		}
	}

}
