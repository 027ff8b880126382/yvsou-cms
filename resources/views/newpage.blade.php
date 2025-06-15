{{--
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-15
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
 
@php
    $items = app(\App\Services\PagelineService::class)->showNewPosts();
@endphp

<div>
    <h2 class="text-xl font-semibold mb-3">New articles</h2>

    <!-- Scrollable container -->
    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-white shadow-sm">
        <ul class="space-y-2">
            @foreach ($items as $item)
                <li>
                    <a href="{{ $item['url'] }}" class="text-blue-600 hover:underline">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
 