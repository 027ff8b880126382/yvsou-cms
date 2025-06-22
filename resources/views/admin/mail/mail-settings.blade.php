{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-06-22
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
<x-guest-layout>
    <div class="flex h-screen items-center justify-center bg-gray-50">
        <div class="w-full max-w-md p-6 bg-white rounded shadow">

            <x-slot name="header">Mail Settings</x-slot>

            @if(session('success'))
                <div class="bg-green-100 p-4 text-green-800 mb-4">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.setmail.update') }}" class="space-y-4">
                @csrf

                @foreach(['host', 'port', 'encryption', 'username', 'password', 'from_address', 'from_name'] as $field)
                    <div>
                        <label class="block font-medium capitalize">{{ str_replace('_', ' ', $field) }}</label>
                        <input type="text" name="{{ $field }}" value="{{ $settings[$field] ?? '' }}"
                            class="w-full border rounded p-2">
                    </div>
                @endforeach

                <button class="bg-blue-500 text-white px-4 py-2 rounded">Save Settings</button>
            </form>
        </div>
    </div>
</x-guest-layout>