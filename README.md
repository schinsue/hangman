## Hangman Assignment

[Live demo](https://qandidate-schinsue.c9.io/games) -- Might be offline at time of viewing as this is hosted by cloud9, gimme a mail if that happens.

I've used the laravel framework to make a quick prototype. 

All requirements are met. Take note that for updating resources it's best practice to use PUT / PATCH (idempotence) and not POST as was given in the assignment. Laravel and Rails use this as convention, Rails is gonna change to PATCH in their next version. So I've used PUT to update the resource/{id}. Hope you don't mind :)

You can POST or PUT using the postman chrome extension if necessary.

###Files of Interest:

**Routes:**
app/routes.php

**Game logic:**
app/controllers/GameController.php
app/models/Game.php
app/views/games.blade.php

**Tests:**
app/tests/GameTest.php
app/seeds/GameTableSeeder.php

**Database migrations:**
app/database/migrations/2015_01_09_231311_create_games_table.php
app/database/migrations/2015_01_09_233055_create_columns_games_table.php

Time spent in total: About 6 hours.

PS: Tests are included. Also I would've put the wordlist in the database, but since that wasn't the requirement this solution will suffice.