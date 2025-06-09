{{--
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
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
    <h2>Step 1: Environment Setup</h2>

    <form method="POST" action="{{ route('install.saveEnv') }}">
        @csrf
        <div class="mb-3">
            <label>App Name</label>
            <input type="text" name="app_name" class="form-control" value="yvsou-cms">
        </div>
        <div class="mb-3">
            <label>URL Site</label>
            <input type="text" name="app_url" class="form-control" value="localhost">
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
            <input type="text" name="db_database" class="form-control">
        </div>
        <div class="mb-3">
            <label>Database Username</label>
            <input type="text" name="db_username" class="form-control">
        </div>
        <div class="mb-3">
            <label>Database Password</label>
            <input type="password" name="db_password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Next Step</button>
    </form>
</body>
</html>
