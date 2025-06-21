<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-21
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

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\App;
use App\Services\LocaleService;


class HomeController extends Controller
{

    public function home()
    {

        return view('home'); // resources/views/domainview/index.blade.php
    }
    public function about()
    {
        $lang = (new LocaleService())->getcurlangcode();
        return view('page.about', [
            'aboutText' => config("yvsou_custom_config.$lang.about"),
        ]);
    }
    public function contact()
    {
        $lang = (new LocaleService())->getcurlangcode();
        return view('page.contact', [
            'aboutText' => config("yvsou_custom_config.$lang.contact"),
        ]);
    }
    public function profile()
    {
        $lang = (new LocaleService())->getcurlangcode();
        return view('page.profile', [
            'aboutText' => config("yvsou_custom_config.$lang.profile"),
        ]);
    }
    public function terms()
    {
        $lang = (new LocaleService())->getcurlangcode();
        return view('page.terms', [
            'aboutText' => config("yvsou_custom_config.$lang.terms"),
        ]);
    }
    public function privacy()
    {
        $lang = (new LocaleService())->getcurlangcode();
        return view('page.privacy', [
            'aboutText' => config("yvsou_custom_config.$lang.privacy"),
        ]);
    }
    public function help()
    {
        $lang = (new LocaleService())->getcurlangcode();
        $aboutMd = config("help_config.$lang.about", '# Content not found');
        return view('page.help', compact('aboutMd'));

    }


}