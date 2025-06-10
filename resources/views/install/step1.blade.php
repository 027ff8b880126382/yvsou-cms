{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-06-08
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
--}}
<!DOCTYPE html>
<html>

<head>
    <title>yvsou-cms Installer - Step 1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container py-5">
    

    <form method="POST" action="{{ route('install.saveEnv') }}">
        @csrf
         <h2> 1: Environment Setup</h2>
        <div class="mb-3">
            <label>App Name</label>
            <input type="text" name="app_name" class="form-control" value="yvsou-cms">
        </div>
        <div class="mb-3">
            <label>URL Site</label>
            <input type="text" name="app_url" class="form-control" value="http://127.0.0.1:8000">
        </div>
        <div class="mb-3">
            <label>Database Host</label>
            <input type="text" name="db_host" class="form-control" value="127.0.0.1">
        </div>
        <div class="mb-3">
            <label>Database Port</label>
            <input type="text" name="db_port" class="form-control" value="3306">
        </div>
        <div class="mb-3">
            <label>Database Name</label>
            <input type="text" name="db_name" class="form-control">
        </div>
        <div class="mb-3">
            <label>Database Username</label>
            <input type="text" name="db_user" class="form-control">
        </div>
        <div class="mb-3">
            <label>Database Password</label>
            <input type="password" name="db_pass" class="form-control">
        </div>

        <h2> 2: Create Admin</h2>


        <div class="mb-3">
            <label>Admin account Name</label>
            <input name="name" placeholder="Admin Name" required>
        </div>

        <div class="mb-3">
            <label>Email Address</label>
            <input name="email" placeholder="email" required>
        </div>

        <div class="mb-3">
            <label>Admin Password</label>
            <input name="password" type="password" placeholder="Password" required>
        </div>

<h2> 3: Cunstom Config</h2>

<div class="mb-3">
      <label>Admin Super Power ? </label>

      <label for="is_adminsp" class="flex items-center cursor-pointer">
       
        <div class="relative">
          <input id="is_adminsp" type="checkbox" name="is_adminsp" value="1" class="sr-only peer">
          <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-green-500"></div>
          <div
            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-full">
          </div>
        </div>

      </label>

    </div>
     
    <div class="mb-3">

      <label for="language" class="block text-sm font-medium text-gray-700 mb-1">🌐 Choose default Language</label>
      <select name="default_lang" id="default_lang"
        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <option value="en">🇺🇸 English</option>
        <option value="zh">🇨🇳 中文</option>
        <option value="ja">🇯🇵 日本語</option>
        <option value="fr">🇫🇷 Français</option>
      </select>
    </div>

     
    <div class="mb-3">
      <label for="multilanguages" class="block text-sm font-medium text-gray-700 mb-1">🌐 Choose Languages</label>
      <select id="lang_set" name="lang_set[]" multiple
        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-40">
        <option value="en">🇺🇸 English</option>
        <option value="zh">🇨🇳 中文</option>
        <option value="ja">🇯🇵 日本語</option>
        <option value="fr">🇫🇷 Français</option>
      </select>
    </div>
        <button type="submit" class="btn btn-primary">Create   Config</button>
    </form>
</body>

</html>