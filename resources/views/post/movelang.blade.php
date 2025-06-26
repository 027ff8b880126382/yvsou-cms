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
<div class="max-w-xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <form id="copypostlink" method="POST" action="{{ route('post.movelangupdate', compact('groupid', 'pid')) }}"
          class="bg-white p-6 rounded-lg shadow space-y-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="groupid" value="{{ $groupid }}">
        <input type="hidden" name="pid" value="{{ $pid }}">

        <!-- Language Dropdown -->
        <div>
            <label for="language" class="block text-sm font-medium text-gray-700">
                {{ __('post.select_lang') }}
            </label>
            <select name="language" id="language"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @foreach ($langIdSet as $item)
                    <option value="{{ $item['langid'] }}">{{ $item['language'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('post.move_targetlang') }}
            </button>
        </div>
    </form>
</div>
@endsection
 