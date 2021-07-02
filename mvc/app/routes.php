<?php
/*
 * Este archivo va a contener TODAS las rutas de
 * nuestra aplicación.
 *
 * Para esto, vamos a crear una clase Route cuya
 * función sea la de registrar y administrar las rutas.
 */
use DaVinci\Core\Route;

// Registramos la primer ruta! :D
Route::add('POST', '/users/register', 'UserController@register');
Route::add('PUT', '/auth/users/edit/user', 'UserController@editUser');
Route::add('PUT', '/auth/users/edit/password', 'UserController@editPassword');
Route::add('PUT', '/auth/users/edit/biography', 'UserController@editBiography');

Route::add('POST', '/auth/posts/create', 'PostController@create');
Route::add('DELETE', '/auth/posts/delete/{id}', 'PostController@delete');
Route::add('GET', '/auth/posts/getByUserId/{id}', 'PostController@byUser');
Route::add('GET', '/auth/posts/{id}', 'PostController@byId');
Route::add('GET', '/auth/posts', 'PostController@getAll');
Route::add('PUT', '/auth/posts/edit', 'PostController@edit');

Route::add('POST', '/auth/comments/create', 'CommentController@create');
Route::add('DELETE', '/auth/comments/delete/{id}', 'CommentController@delete');
Route::add('GET', '/auth/comments/getByPost/{id}', 'CommentController@byPost');
Route::add('PUT', '/auth/comments/edit', 'CommentController@edit');

Route::add('POST', '/auth/login', 'AuthController@login');
Route::add('DELETE', '/auth/logout', 'AuthController@logout');
Route::add('GET', '/auth/getAuth', 'AuthController@getAuth');