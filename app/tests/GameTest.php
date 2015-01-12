<?php

/**
 * Tests use sqlite in memory database
 * Config files --> app/config/testing/database.php
 * Seeder file --> app/seeds/DatabaseSeeder.php
 *
 * @return void
 */
class GameTest extends TestCase {

	/**
	 * Default preparation for each test
	 *
	 */
	public function setUp()
	{
	    parent::setUp(); // Don't forget this!
	 
	    $this->prepareForTests();
	}
	
	/**
	 * Test if GET /games returns right view file.
	 *
	 * @return void
	 */
	public function testIndexGames()
	{
		$crawler = $this->client->request('GET', '/games');
		
		// Check if it is the correct view (games) and html contains one of the database entries
		$this->assertEquals('games', $this->client->getResponse()->original->getName());
		$this->assertGreaterThan(0, $crawler->filter('html:contains("t.st.ng")')->count());
	}
	
	/**
	 * Test if POST /games creates a game and checks if game is correct
	 *
	 * @return void
	 */
	public function testCreateGame()
	{
		$count = Game::all()->count();
		$crawler = $this->client->request('POST', '/games');
		
		// Assume redirection
		$this->assertResponseStatus(302);
		
		// Check if it added an extra game in the DB
		// Because of the DB setup, nothing can be NULL and defaults should be ok
		$this->assertTrue(Game::all()->count() !== $count);
		
		$game = Game::find(5);
		
		// Check if the new game was saved correctly (invalid is the default value for words and solutions)
		$this->assertTrue(strlen($game->word) === strlen($game->solution));
		$this->assertTrue($game->word !== null && $game->solution !== null);
		$this->assertTrue((int)$game->tries_left === 11);
		$this->assertTrue($game->status === 'busy');
	}
	
	/**
	 * Check if PUT /games/{id} updates in the right way
	 *
	 * @return void
	 */
	public function testUpdateGame()
	{
		// Busy games should update, if input correct
		$this->client->request('PUT', '/games/1', array('char' => 'a') );
		$this->assertResponseOk();
		$response = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals('Success! Game #1 updated!', $response->message);
		
		// If guess incorrect word should stay the same, and status too, only tries_left decrement
		$game = Game::find(1);
		$this->assertEquals(1, $game->tries_left);
		$this->assertEquals('busy', $game->status);
		$this->assertEquals('testin.', $game->word);
		
		// New request
		$this->client->request('PUT', '/games/1', array('char' => 'g') );
		
		// If word completely guessed, status should change to success, tries the same and the word should change
		$game = Game::find(1);
		$this->assertEquals(1, $game->tries_left);
		$this->assertEquals('success', $game->status);
		$this->assertEquals('testing', $game->word);
		
		// new request
		$this->client->request('PUT', '/games/4', array('char' => 'z') );
		
		// If tries get to 0, put game in fail state and don't change the word
		$game = Game::find(4);
		$this->assertEquals(0, $game->tries_left);
		$this->assertEquals('fail', $game->status);
		$this->assertEquals('.......', $game->word);
		
		// Failed games should not update
		$failedGame = Game::find(3);
		$this->client->request('PUT', "/games/3", array('char' => 'a') );
		$this->assertFalse($this->client->getResponse()->isOk());
		$response = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals('Fail! Game #3 is already over!', $response->message);
		
		// Success games should not update
		$successGame = Game::find(2);
		$this->client->request('PUT', "/games/2", array('char' => 'a') );
		$this->assertFalse($this->client->getResponse()->isOk());
		$response = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals('Fail! Game #2 is already over!', $response->message);
		
		// Give error if char is not [a-z]
		$this->client->request('PUT', "/games/2", array('char' => 1) );
		$this->assertFalse($this->client->getResponse()->isOk());
		$response = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals('Something was wrong, check the request body!', $response->message);
	}
	
	/**
	 * Test if /GET /games/{id} gives the right JSON response
	 *
	 * @return void
	 */
	public function testShowGame()
	{
		// Show game #1
		$this->client->request('GET', '/games/1');
	
		// Check if it's a JSON response
		$this->assertTrue(
		    $this->client->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		  	)
	  	);
	  	
	  	// Check if
	  	$response = json_decode($this->client->getResponse()->getContent());
	  	
	  	// Check if it contains these fields, but also if it's correct with game #1 seed info :)
	  	$this->assertEquals('testin.', $response->word);
	  	$this->assertEquals('testing', $response->solution);
	  	$this->assertEquals(2, $response->tries_left);
	  	$this->assertEquals('busy', $response->status);
	}
	
	/**
	 * Migrates the database and set the mailer to 'pretend'.
	 * This will cause the tests to run quickly.
	 *
	 */
	private function prepareForTests()
	{
	    Artisan::call('migrate');
	    Mail::pretend(true);
	    $this->seed();
	}
}