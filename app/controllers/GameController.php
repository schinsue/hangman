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
		    	return (Game::tryGuess($id, $guess)) ? Response::json(array('status' => 'success', 'message' => "Success! Game #$id updated!"), 200)
		  									 		 : Response::json(array('status' => 'fail', 'message' => "Fail! Game #$id is already over!"), 500);
		    }
		    
		}

		return Response::json(array('status' => 'error', 'message' => 'Something was wrong, check the request body!'), 500);
	}

}
