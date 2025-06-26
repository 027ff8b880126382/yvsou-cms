{{--
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-26
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

@extends('layouts.app')

@section('content')

    <h1>Plugin Manager</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Status</th>
                <th>Dependencies</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($plugins as $plugin)
            <tr>
                <td>{{ $plugin['name'] }}</td>
                <td>{{ $plugin['version'] }}</td>
                <td>{{ $plugin['enabled'] ? 'Enabled' : 'Disabled' }}</td>
                <td>
                    <pre>{{ json_encode($plugin['dependencies'], JSON_PRETTY_PRINT) }}</pre>
                </td>
                <td>
                    <a href="{{ url('/admin/plugins/toggle/'.$plugin['name']) }}">
                        {{ $plugin['enabled'] ? 'Disable' : 'Enable' }}
                    </a> |
                    <a href="{{ url('/admin/plugins/delete/'.$plugin['name']) }}">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Upload Plugin</h2>
    <form action="{{ url('/admin/plugins/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="plugin_zip" required>
        <button type="submit">Upload ZIP</button>
    </form>
@endsection
