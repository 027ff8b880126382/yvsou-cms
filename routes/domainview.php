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
use App\Http\Controllers\DomainViewController;
use App\Http\Controllers\DomainItemController;


// Public
Route::prefix('domainview')->name('domainview.')->group(function () {
  Route::get('/{groupid}', [DomainViewController::class, 'index'])->name('index');
});


// Authenticated

Route::middleware(['auth'])->prefix('domainview')->name('domainview.')->group(function () {
  Route::get('/createsub/{groupid}', [DomainViewController::class, 'createsub'])
    ->name('createsub');


  Route::post('storesub', [DomainViewController::class, 'storesub'])
    ->name('storesub');



  Route::get('/editsub/{groupid}', [DomainViewController::class, 'editsub'])->name('editsub');



  Route::post('updatesub', [DomainViewController::class, 'updatesub'])
    ->name('updatesub');




  Route::post('destroysub', [DomainViewController::class, 'destroysub'])
    ->name('destroy');

  Route::delete('/{groupid}', [DomainViewController::class, 'destroysub'])->name('destroysub');



  //Route::post('setpub', [DomainViewController::class, 'setpub'])
  //  ->name('setpub');

  Route::patch('/setpub/{groupid}', [DomainViewController::class, 'setpub'])->name('setpub');



  //Route::post('setprivate', [DomainViewController::class, 'setprivate'])
  //  ->name('setprivate');

  Route::patch('/setprivate/{groupid}', [DomainViewController::class, 'setprivate'])->name('setprivate');



 // Route::post('trash', [DomainViewController::class, 'trash'])
 //   ->name('trash');

  Route::patch('/trash/{groupid}', [DomainViewController::class, 'trash'])->name('trash');



 // Route::post('untrash', [DomainViewController::class, 'untrash'])
 //   ->name('untrash');

  Route::patch('/{groupid}/untrash', [DomainViewController::class, 'untrash'])->name('untrash');



  //Route::post('auditcheck', [DomainViewController::class, 'auditcheck'])
  //  ->name('auditcheck');

  Route::patch('/{groupid}/auditcheck', [DomainViewController::class, 'auditcheck'])->name('auditcheck');



  //Route::post('audituncheck', [DomainViewController::class, 'audituncheck'])
  //  ->name('audituncheck');

  Route::patch('/{groupid}/audituncheck', [DomainViewController::class, 'audituncheck'])->name('audituncheck');


});
