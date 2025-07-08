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

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\DomainName;
use App\Services\LocaleService;
use Illuminate\Http\Request;
use App\Services\PagelineService;
use App\Services\PostService;
use App\Services\RightsService;
use App\Services\UserService;
use App\Services\DomainService;
use App\Models\DomainPostId;
use App\Models\DomainManager;
use App\Models\User;
use App\Models\DomainPost;


class GroupController extends Controller
{


    public function joingroup($groupid)
    {
        DomainName::joinGroup($groupid);

        return back()->with('message', 'You have left the group.');
    }

    public function quitgroup($groupid)
    {
        DomainName::quitGroup($groupid);

        return back()->with('message', 'You have left the group.');
    }
    public function approvegroup($groupid)
    {
        if (!config('app.pro')) {
            return redirect('/upgrade')->with('error', 'Your company does not have Pro access.');
        }
    }

    public function invitegroup($groupid)
    {
        if (!config('app.pro')) {
            return redirect('/upgrade')->with('error', 'Your company does not have Pro access.');
        }
    }

    public function auditcheckgroup($groupid)
    {
        if (!config('app.pro')) {
            return redirect('/upgrade')->with('error', 'Your company does not have Pro access.');
        }
    }

    public function unauditcheckgroup($groupid)
    {
        if (!config('app.pro')) {
            return redirect('/upgrade')->with('error', 'Your company does not have Pro access.');
        }
    }
    public function groupmessage($groupid)
    {
        if (!config('app.pro')) {
            return redirect('/upgrade')->with('error', 'Your company does not have Pro access.');
        }
    }
    public function setpublic(Request $request)
    {
        logger('setpublic');
        $request->validate([
            'groupid' => 'required|String' // or string if your IDs are UUIDs
        ]);

        $groupid = $request->groupid;
        logger($groupid);
        DomainManager::setPublic($groupid);
        return back()->with('message', 'You have setpublic.');
    }

    public function setprivate(Request $request)
    {
        logger('setprivate');
        $request->validate([
            'groupid' => 'required|String' // or string if your IDs are UUIDs
        ]);

        $groupid = $request->groupid;
        logger($groupid);
        DomainManager::setPrivate($groupid);

        return back()->with('message', 'You have setprivate.');
    }
}

