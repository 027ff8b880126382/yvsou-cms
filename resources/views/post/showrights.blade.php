{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-07-10
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
    <div class="container">
        <h1>Manage Rights for Post: {{ $post->id }} in Group {{ $groupid }}</h1>

        @if (session('success'))
            <div class="bg-green-200 p-2 my-2">{{ session('success') }}</div>
        @endif



        <table class="table-auto border-collapse w-full">
            <thead>

                <tr>
                    <th class="text-left px-4 py-2">Role</th>
                    <th class="text-left px-4 py-2">Audit</th>
                    <th class="text-left px-4 py-2">Read</th>
                    <th class="text-left px-4 py-2">Write</th>
                    <th class="text-left px-4 py-2">Execute</th>
                    <th class="text-left px-4 py-2">Action</th>
                </tr>

            </thead>
            <tbody>

                @foreach ($rights as $role)
                    <tr class="border-t">
                        <form method="POST" action="{{ route('post.file-rights.update', $post->id) }}">

                            @csrf
                            <input type="hidden" name="groupid" value="{{ $groupid }}">
                            <input type="hidden" name="role_key" value="{{ $role['key'] }}">
                            <input type="hidden" name="charorder" value="{{ $role['index'] }}">

                            <td class="p-2">{{ $role['label'] }}</td>

                            @php

                                $value = hexdec($role['value'] ?? '0');

                            @endphp

                            <td class="p-2">
                                <input type="radio" name="maudit" value="1" {{ ($value >> 3) & 1 ? 'checked' : '' }}>Yes
                                <input type="radio" name="maudit" value="0" {{ ((($value >> 3) & 1) == 0) ? 'checked' : '' }}>No
                            </td>
                            <td class="p-2">
                                <input type="radio" name="mread" value="1" {{ ($value >> 2) & 1 ? 'checked' : '' }}>Yes
                                <input type="radio" name="mread" value="0" {{ ((($value >> 2) & 1) == 0) ? 'checked' : '' }}>No
                            </td>
                            <td class="p-2">
                                <input type="radio" name="mwrite" value="1" {{ ($value >> 1) & 1 ? 'checked' : '' }}>Yes
                                <input type="radio" name="mwrite" value="0" {{ ((($value >> 1) & 1) == 0) ? 'checked' : '' }}>No
                            </td>
                            <td class="p-2">
                                <input type="radio" name="mexecute" value="1" {{ ($value >> 0) & 1 ? 'checked' : '' }}>Yes
                                <input type="radio" name="mexecute" value="0" {{ ((($value >> 0) & 1) == 0) ? 'checked' : '' }}>No
                            </td>
                            <td class="p-2">
                                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Save</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection