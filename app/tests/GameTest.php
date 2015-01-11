<?php

class GameTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testWorkingCreateGame()
	{
		$crawler = $this->client->request('POST', '/games');
		
		$this->assertTrue($this->client->getResponse()->isOk());

		// Random word picked
		
		// Alles wordt succesvol opgeslagen in database
		
		// return ID van opgeslagen record
		
		// check of woord klopt met regel van woordlijst
		
		// check of tries op 11 staan
		
		// check of status op busy staat
		
		// check of word gelijk is aan solution + puntjes
		$countwordlist = count(file('words.english'));

	}
	
}
