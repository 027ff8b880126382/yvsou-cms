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


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function form()
    {
        $path = base_path('config/yvsou_config.php');
        if (file_exists($path)) {
            return redirect('/')->with('message', 'Site already installed.');
        }

        return view('install');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required',
            'app_url' => 'required|url',
            'default_lang' => 'required',
            'lang_set' => 'required|array|min:1', // Make sure language_set is an array and has at least one value
            'db_host' => 'required',
            'db_port' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);
      //  logger("message", $validated['lang_set']);

        $langSet = $validated['lang_set']; // lang_set is already an array
       

        $data = [
            'APP_NAME' => $validated['app_name'],
            'APP_ENV' => 'production',
            'APP_DEBUG' => false,
            'APP_URL' => $validated['app_url'],
            'DEFAULT_LANGUAGE' => $validated['default_lang'],

            'LANGUAGESET' => $langSet,  // Store the array directly
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $validated['db_host'],
            'DB_PORT' => $validated['db_port'],
            'DB_DATABASE' => $validated['db_name'],
            'DB_USERNAME' => $validated['db_user'],
            'DB_PASSWORD' => $validated['db_pass']
        ];

        $configPath = base_path('config');
        if (!is_dir($configPath)) {
            mkdir($configPath, 0755, true);
        }

        file_put_contents($configPath . '/yvsou_config.php', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        chmod($configPath . '/yvsou_config.php', 0644);

        return redirect('/')->with('message', '✅ Site installed!');
    }
}
