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
Route::add('PUT', '/users/edit/user', 'UserController@editUser');


Route::add('POST', '/auth/login', 'AuthController@login');
Route::add('DELETE', '/auth/logout', 'AuthController@logout');
Route::add('GET', '/auth/check', 'AuthController@check');