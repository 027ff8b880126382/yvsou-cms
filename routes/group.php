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

use App\Http\Controllers\Admin\PluginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Group\GroupController;



// Public


Route::prefix('group')->name('group.')->group(function () {

});



Route::middleware(['auth'])->prefix('group')->name('group.')->group(function () {

    Route::post('/setpub', [GroupController::class, 'setpub'])->name('setpub');
    Route::post('/setprivate', [GroupController::class, 'setprivate'])->name('setprivate');

    Route::patch('/{groupid}/joingroup', [GroupController::class, 'joingroup'])->name('joingroup');
    Route::patch('/{groupid}/quitgroup', [GroupController::class, 'quitgroup'])->name('quitgroup');
    Route::patch('/{groupid}/approvegroup', [GroupController::class, 'approvegroup'])->name('approvegroup');
    Route::patch('/{groupid}/invitegroup', [GroupController::class, 'invitegroup'])->name('invitegroup');
    Route::patch('/{groupid}/auditcheckgroup', [GroupController::class, 'auditcheckgroup'])->name('auditcheckgroup');
    Route::patch('/{groupid}/unauditcheckgroup', [GroupController::class, 'unauditcheckgroup'])->name('unauditcheckgroup');
    Route::patch('/{groupid}/groupmessage', [GroupController::class, 'groupmessage'])->name('groupmessage');


});

