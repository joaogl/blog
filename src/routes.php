
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
    /* GET  */ Route::get('blog/{id}', 'jlourenco\blog\Controllers\BlogController@show');
    /* GET  */ Route::get('category/{id}', 'jlourenco\blog\Controllers\BlogController@showByCategory');
    /* GET  */ Route::get('search/{terms?}', 'jlourenco\blog\Controllers\BlogController@search');
    /* POST */ Route::post('comment/{blogId}', array('as' => 'comment.post', 'uses' => 'jlourenco\blog\Controllers\BlogController@postComment'));

});

/**
 * Frontend route group
 *
 * All the "restricted area" routes
 * are defined here.
 */
Route::group(array('prefix' => '/admin', 'middleware' => ['webAdmin', 'auth']), function ()
{

    # Blog Management
    Route::group(array('prefix' => 'categories'), function () {
        Route::get('/list', array('as' => 'categories', 'uses' => 'jlourenco\blog\Controllers\CategoryController@index'));
        Route::get('/create', array('as' => 'create.category', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getCreate'));
        Route::post('/create', 'jlourenco\blog\Controllers\CategoryController@postCreate');
        Route::get('{blogId}/edit', array('as' => 'category.update', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getEdit'));
        Route::post('{blogId}/edit', 'jlourenco\blog\Controllers\CategoryController@postEdit');
        Route::get('{blogId}/delete', array('as' => 'delete/category', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getDelete'));
        Route::get('{blogId}/confirm-delete', array('as' => 'confirm-delete/category', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getModalDelete'));
        Route::get('{blogId}/restore', array('as' => 'restore/category', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getRestore'));
        Route::get('deleted',array('as' => 'categories.deleted', 'uses' => 'jlourenco\blog\Controllers\CategoryController@getDeletedCategories'));
        Route::get('{blogId}', array('as' => 'category.show', 'uses' => 'jlourenco\blog\Controllers\CategoryController@show'));
    });

    Route::group(array('prefix' => 'posts'), function () {
        Route::get('/list', array('as' => 'posts', 'uses' => 'jlourenco\blog\Controllers\PostController@index'));
        Route::get('/create', array('as' => 'create.post', 'uses' => 'jlourenco\blog\Controllers\PostController@getCreate'));
        Route::post('/create', 'jlourenco\blog\Controllers\PostController@postCreate');
        Route::get('{blogId}/edit', array('as' => 'post.update', 'uses' => 'jlourenco\blog\Controllers\PostController@getEdit'));
        Route::post('{blogId}/edit', 'jlourenco\blog\Controllers\PostController@postEdit');
        Route::get('{blogId}/delete', array('as' => 'delete/post', 'uses' => 'jlourenco\blog\Controllers\PostController@getDelete'));
        Route::get('{blogId}/confirm-delete', array('as' => 'confirm-delete/post', 'uses' => 'jlourenco\blog\Controllers\PostController@getModalDelete'));
        Route::get('{blogId}/restore', array('as' => 'restore/post', 'uses' => 'jlourenco\blog\Controllers\PostController@getRestore'));
        Route::get('deleted',array('as' => 'posts.deleted', 'uses' => 'jlourenco\blog\Controllers\PostController@getDeletedCategories'));
        Route::get('{blogId}', array('as' => 'post.show', 'uses' => 'jlourenco\blog\Controllers\PostController@show'));
    });

});
