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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	//
	// }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Choose random word from wordlist and clean it up
		$wordlist = file('../words.english'); 
		$randomNum = array_rand($wordlist);
		$randomWord = str_replace(array("\n", " "), '', $wordlist[$randomNum]);
		
		// Put a dot for each letter of the word
		$word = str_repeat('.', strlen($randomWord));
		
		// Save this in the database as a new game
		$game = new Game;
		$game->word = $word;
		$game->solution = $randomWord;
		$game->save();
		
		return Redirect::to('games')->with('message', 'Game succesfully created!');
		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Response::json(array('id' => $id, 'name' => 'Steve', 'state' => 'CA'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
