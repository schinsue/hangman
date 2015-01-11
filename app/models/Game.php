<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function(ModelNotFoundException $e)
{
    return Response::make('Not Found', 404);
});

class Game extends Eloquent {
    
    protected $guarded = array('id');
    
}