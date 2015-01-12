<?php
 
class GameTableSeeder extends Seeder {
 
    public function run()
    {
        Game::create(array('word' => 'testin.', 'solution' => 'testing', 'tries_left' => 2));
        Game::create(array('word' => 'testing', 'solution' => 'testing', 'status'=> 'success'));
        Game::create(array('word' => 't.st.ng', 'solution' => 'testing', 'status'=> 'fail', 'tries_left' => 0));
        Game::create(array('word' => '.......', 'solution' => 'testing', 'tries_left' => 1));
    }
 
}