<?php
/**
 * Frontend route group
 *
 * All the "restricted area" routes
 * are defined here.
 */
Route::group(array('prefix' => '/', 'middleware' => 'webPublic'), function ()
{

    # Blog pages
    /* GET  */ Route::get('blog', 'jlourenco\blog\Controllers\BlogController@index');

});
