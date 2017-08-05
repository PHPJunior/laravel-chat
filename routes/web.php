<?php
/**
 * Created by PhpStorm.
 * User: nyinyilwin
 * Date: 6/23/17
 * Time: 11:30 AM.
 */
Route::resource('groups', 'PhpJunior\LaravelChat\Http\Controllers\GroupController');
Route::resource('conversations', 'PhpJunior\LaravelChat\Http\Controllers\ConversationController');
