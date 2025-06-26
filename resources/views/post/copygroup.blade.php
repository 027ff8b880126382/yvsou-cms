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


    <form id="copypostlink" method="POST" action="{{route('post.copygroupupdate', compact('groupid', 'pid')) }}">
        @csrf
        @method('PATCH')
        <div>
            <label for="editor" class="block text-sm font-medium text-gray-700">target groupid</label>
            <input type="text" name="desgroupid" value="" size="30" maxlength="350">
            <input type="hidden" name="groupid" value="{{ $groupid }}">
            <input type="hidden" name="pid" value="{{ $pid }}">

            </br>

            </br>
            <div class="flex justify-end">

                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    copy post to target group
                </button>
            </div>
        </div>
    </form>

@endsection