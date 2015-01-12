<?php

class GameController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Game::all();
		
		return View::make('games')->with( 'data', $data );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
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
		$game->save();
	
		return Redirect::to('games')->with('message', "Game #$game->id succesfully created!");
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$game = Game::find($id);
		return Response::json(array('word' => $game->word, 'solution' => $game->solution, 'tries_left' => $game->tries_left, 'status' => $game->status, 'created_at' => $game->created_at));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Check if input exists and is consistent to char=a format
		if (Input::has('char'))
		{
		    $guess = strtolower(Input::get('char'));

		    // Check if strlen is 1 and matches the regex a-z
		    if (strlen($guess) === 1 && preg_match('/[a-z]/', $guess))
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
			    	
			    	return Response::json(array('status' => 'success', 'message' => "Success! Game #$game->id updated!"), 200);
		    	}

		    	return Response::json(array('status' => 'fail', 'message' => "Fail! Game #$game->id is already over!"), 500);
		    	
		    }
		    
		}

		return Response::json(array('status' => 'error', 'message' => 'Something was wrong, check the request body!'), 500);
	}

}
