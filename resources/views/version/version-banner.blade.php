{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-07-01
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
{{-- resources/views/version/version-banner.blade.php --}}
@inject('versionCheck', 'App\Services\AutoUpdaterService')

@php
    $result = $versionCheck->isOutdated();  
@endphp
 
<div class="bg-gray-100 text-gray-800 p-4 mb-4 rounded">
    <strong>Current Version:</strong> {{ $result['current'] }}

    @if ($result['outdated'])
        <br>
        <strong class="text-yellow-800">New Version Available!</strong><br>
        Latest version: <strong>{{ $result['latest'] }}</strong> —
        
        <form method="POST" action="{{ route('admin.updater.run') }}">
            @csrf
            <button class="px-4 py-2 bg-green-600 text-white rounded">Update Now</button>
        </form>
    @else
        <br>
        ✅ You are up-to-date.
    @endif
</div>