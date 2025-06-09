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

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    function fixPermissions($dir)
    {
        if (!is_dir($dir))
            return;

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..')
                continue;

            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                @chmod($path, 0775);
                $this->fixPermissions($path); // recursive
            } else {
                @chmod($path, 0664);
            }
        }
        @chmod($dir, 0775);
    }




    public function welcome()
    {

        return view('install.welcome');

    }


    public function envForm()
    {

        /* 
        // Check storage structure
        $dirs = [
            'storage/app',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/testing',
            'storage/framework/views',
            'storage/logs',
        ];

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        $writableDirs = ['storage', 'bootstrap/cache'];
        foreach ($writableDirs as $dir) {
            fixPermissions($dir);
            if (!is_writable($dir)) {
                die("❌ '$dir' is not writable and could not be fixed. Please set permissions manually.");
            }
        }

         

        // Optionally clear old temp files
        array_map('unlink', glob('storage/logs/*.log'));
        array_map('unlink', glob('storage/framework/sessions/*'));
        array_map('unlink', glob('storage/framework/views/*'));
        */
        return view('install.step1');
    }

    public function saveEnv(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required',
            'app_url' => 'required|url',
          #  'default_lang' => 'required',
          #  'lang_set' => 'required|array|min:1', // Make sure language_set is an array and has at least one value
            'db_host' => 'required',
            'db_port' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);
        //  logger("message", $validated['lang_set']);

       # $langSet = $validated['lang_set']; // lang_set is already an array


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
 
        $env = File::get(base_path('env.example'));
        $env = str_replace('DB_DATABASE=laravel', 'DB_DATABASE=' . $request->db_name, $env);
        $env = str_replace('DB_USERNAME=root', 'DB_USERNAME=' . $request->db_user, $env);
        $env = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $request->db_pass, $env);
        File::put(base_path('.env'), $env);
        Artisan::call('config:clear');
        return redirect('/install/step3');
    }



    public function saveCustomConfig(Request $request)
    {
        $validated = $request->validate([
          
            'default_lang' => 'required',
            'lang_set' => 'required|array|min:1', // Make sure language_set is an array and has at least one value
         
        ]);
        //  logger("message", $validated['lang_set']);

       # $langSet = $validated['lang_set']; // lang_set is already an array

        $langSet = "[jp,cn]";
        $data = [
            
            'DEFAULT_LANGUAGE' => $validated['default_lang'],

            'LANGUAGESET' => $langSet,  // Store the array directly
       
        ];

        $configPath = base_path('config');
        file_put_contents($configPath . '/yvsou_config.php', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        chmod($configPath . '/yvsou_config.php', 0644);

     
    }


    public function runMigrations()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            return back()->withErrors(['db' => $e->getMessage()]);
        }

        return view('install.step3');
    }

    public function createAdmin(Request $request)
    {
        $model = \App\Models\User::class;

        $model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        File::put(storage_path('installed.lock'), now());

        return redirect('/install/done');
    }

    public function done()
    {
        return view('install.done');
    }
}
