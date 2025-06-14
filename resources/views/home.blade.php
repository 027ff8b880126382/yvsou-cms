{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-06-14
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

{{-- resources/views/home.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="p-4 text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Left panel: scrollable on desktop --}}
            <div class="space-y-4 md:col-span-1 md:h-[calc(100vh-6rem)] md:overflow-y-auto md:sticky md:top-16">
                {{-- Search Box --}}
                <div class="bg-white shadow rounded-2xl p-4">
                    @include('search')
                </div>

                {{-- Domain Tree --}}
                <div class="bg-white shadow rounded-2xl p-4">
                    <h2 class="text-xl font-semibold mb-4">Domain Tree</h2>
                    @livewire('show-domain-tree')
                </div>


            </div>

            {{-- Right panel --}}
            <div class="space-y-4 md:col-span-2">
                {{-- New Page --}}
                <div class="bg-white shadow rounded-2xl p-4">
                    @include('newpage')
                </div>

                {{-- New Directory --}}
                <div class="bg-white shadow rounded-2xl p-4">
                    @include('newdir')
                </div>
            </div>

        </div>
    </div>
@endsection