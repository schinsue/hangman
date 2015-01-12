## Hangman Assignment

[Live demo](https://qandidate-schinsue.c9.io/games) -- Might be offline at time of viewing as this is hosted by cloud9, gimme a mail if that happens.

I've used the laravel framework to make a quick prototype.

All requirements are met. Take note that for updating resources it's best practice to use PUT / PATCH (idempotence) and not POST as was given in the assignment. Laravel and Rails use this as convention, Rails is gonna change to PATCH in their next version. So I've used PUT to update the resource/{id}. Hope you don't mind :)

You can POST or PUT using the postman chrome extension if necessary.

Time spent in total: About 6 hours.

PS: Tests are included, If this was a bigger project I would've separated logic in the update function of the GameController.