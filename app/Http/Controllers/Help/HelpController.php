<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-28
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
namespace App\Http\Controllers\Help;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\App;
use App\Services\LocaleService;
use App\Http\Controllers\Controller;


class HelpController extends Controller
{

    public function about()
    {
        $lang = (new LocaleService())->getcurlangcode();

        // Build the path to your .md file
        $path = resource_path("docs/help/{$lang}/about.md");

        // Check if file exists
        if (file_exists($path)) {
            $aboutMd = file_get_contents($path);
        } else {
            $aboutMd = '# Content not found';
        }

        return view('help.about', compact('aboutMd'));
    }

    public function menu()
    {
        $lang = (new LocaleService())->getcurlangcode();

        // Build the path to your .md file
        $path = resource_path("docs/help/{$lang}/menu.md");

        // Check if file exists
        if (file_exists($path)) {
            $menuMd = file_get_contents($path);
        } else {
            $menuMd = '# Content not found';
        }

        return view('help.menu', compact('menuMd'));

    }

    public function search()
    {
         

    }


}