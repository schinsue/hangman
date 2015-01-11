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
			    $table->string('word');
			 	$table->string('solution');
				$table->integer('tries_left')->default(11);
				$table->string('status')->default('busy');
				$table->timestamps();
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
