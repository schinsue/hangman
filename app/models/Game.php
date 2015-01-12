<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function(ModelNotFoundException $e)
{
    return Response::make('Not Found', 404);
});

class Game extends Eloquent {
    
    protected $guarded = array('id');
    
    /**
	 * Handles logic of creating a new game
	 *
	 * @param 
	 * @return mixed
	 */
    public static function createGame()
    {
        // Choose random word from wordlist and clean it up
		$wordlist = file(base_path('words.english')); 
		$randomNum = array_rand($wordlist);
		$randomWord = str_replace(array("\n", " "), '', $wordlist[$randomNum]);
		
		// Put a dot for each letter of the word
		$obfuscatedWord = str_repeat('.', strlen($randomWord));
		
		// Save this in the database as a new game
		$game = new Game;
		$game->word = $obfuscatedWord;
		$game->solution = $randomWord;
		
		return ($game->save()) ? $game->id : false;
    }
    
	/**
	 * Handles the guessing logic
	 *
	 * @param  int  $id, string $guess
	 * @return bool
	 */
    public static function tryGuess($id, $guess)
    {
        $game = Game::findOrFail($id);
    	
    	// Check if game isn't already over
    	if ($game->status === 'busy')
    	{
    		$oldWord = $currentWord = $game->word;
    	
        	// Check and replace if guess is correct
        	for ($i=0; $i<strlen($game->solution); $i++)
        	{
        		if ($game->solution[$i] == $guess)
        			$currentWord[$i] = $guess;
        	}
        	
        	// If the guess is incorrect, decrement tries and if no tries left put game status on fail
        	// If the guess is the same letter that has already been guessed, tries will also be decremented
        	// If guess is correct, change the current word in Database without decrementing
        	if ($currentWord === $oldWord)
        	{
        		if ((int)$game->tries_left === 1)
        		{
        			$game->status = 'fail';
        		}
        		
        		$game->tries_left -= 1;
        	}
        	else 
        	{
        		$game->word = $currentWord;
        	}
        	
        	// If user completed the word after guessing, put game status on success
        	if ($game->word === $game->solution)
        	{
        		$game->status = 'success';
        	}
        	
        	// Save updates
        	$game->save();
        	
        	return true;
    	}
    	else
    	{
    	    return false;
    	}
    }
    
    
}