# MovingWorldsShortCodes

This was built with Laravel which should set up the database you need once you have filled in the .env file with the various details it requires to be able to run on your server.

The file with the code is in /app/Http/Controllers/ApiController.php

Although I have never used Laravel before it seemed the quickest way for me to create you a something to look at and I was very impressed with it.

One thing I did not have time to work out was how it works with user authentication eg. does it work with tokens passed or it's own way of authneticating a user?

I used the poastman app to test out the calls to the API. Postman allows for GET, POST, PUT and DELETE though you would need to supply these in a POST were you to use the Laravel platform in full for the end product.

The api.php file contains the following...

Route::get('shortcodes', 'ApiController@getAllShortcodesForUser');
Route::get('shortcodes/{id}', 'ApiController@getShortcode');
Route::post('shortcodes', 'ApiController@createShortcode');
Route::put('shortcodes/{id}', 'ApiController@updateShortcode');
Route::delete('shortcodes/{id}','ApiController@deleteShortcode');

...which should allow someone who is familiar with the postman app to test the functionality out.



I was very rushed and managed to produce this in a few hours today with no previous Laravel experience. Please consider me for your Junior Full Stack role.

Many thanks,
George
