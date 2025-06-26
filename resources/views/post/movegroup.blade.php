{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
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
        <form id="movepostlink" method="POST" action="{{ route('post.movegroupupdate', compact('groupid', 'pid')) }}"
            class="bg-white p-6 rounded-lg shadow-md space-y-6">
            @csrf
            @method('PATCH')

            <h2 class="text-xl font-semibold text-gray-800">{{ __('post.move_targetid') }}</h2>

            <div>
                <label for="desgroupid" class="block text-sm font-medium text-gray-700">
                    {{ __('post.target_groupid') }}
                </label>
                <input type="text" id="desgroupid" name="desgroupid"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    maxlength="350">
            </div>

            <input type="hidden" name="groupid" value="{{ $groupid }}">
            <input type="hidden" name="pid" value="{{ $pid }}">

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('post.move_targetid') }}
                </button>
            </div>
        </form>
    </div>
@endsection