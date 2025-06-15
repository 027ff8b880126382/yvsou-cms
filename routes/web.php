<?php
/**
 * © 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo   All rights reserved.
 * Author: Lican Huang
 * License: Dual Licensed – GPLv3 or Commercial
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * As an alternative to GPLv3, commercial licensing is available for organizations
 * or individuals requiring proprietary usage, private modifications, or support.
 *
 * Contact: yvsoucom@gmail.com
 * GPL License: https://www.gnu.org/licenses/gpl-3.0.html
 */


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\ProtectedFileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Lang\LangController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;


Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/profile', 'profile')->name('profile');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/help', 'help')->name('help');

Route::view('/message.message', 'message.message')->name('message.message');


 
Route::get('/lang/{locale}', [LangController::class, 'setLang'])->name('lang.setLang');
   
Route::get('/upgrade', function () {
    return view('upgrade'); // or redirect to your commercial landing page
});



 /*
Route::middleware(['SetLocale'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    // other routes...
});
 
Route::middleware('prevent.install')->group(function () {
    Route::get('/install', [InstallController::class, 'welcome'])->name('install.welcome');
   # Route::post('/install', [InstallController::class, 'submit'])->name('install.submit');
});

*/
Route::middleware(['auth'])->get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard'); // ← this "name" is required



Route::post('/search', [SearchController::class, 'search'])->name('search');

Route::get('/headlines', [PostController::class, 'showHeadlines'])->name('headlines.show');
/*
Route::get('/protected/{filename}', [ProtectedFileController::class, 'show'])
    ->where('filename', '.*')  // allow slashes in filename
    ->middleware(['auth']);
*/

Route::get('/protected/{filename}', [ProtectedFileController::class, 'show'])
    ->where('filename', '.*');  // allow slashes in filename



require __DIR__ . '/auth.php';
require __DIR__ . '/domainview.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/post.php';
require __DIR__ . '/group.php';
require __DIR__ . '/toggle.php';
require __DIR__ . '/error.php';
require __DIR__ . '/ Installer.php';


