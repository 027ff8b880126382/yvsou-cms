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
@extends('layouts.app')

@section('content')
    <div class="{{ Agent::isMobile() ? 'mbcontent' : 'content' }}">
        <li class="selected">
            <h2>
                {{ __('Your Group') }} {!! get_joinGroupLink_by_uniqid($groupid) !!} {{ __('Articles') }}
            </h2>
        </li>

        <table class="table-auto border-collapse border border-gray-300 w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">{{ __('From') }}</th>
                    <th class="border px-4 py-2">{{ __('Message') }}</th>
                    <th class="border px-4 py-2">{{ __('Time') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($castMessages as $msg)
                    <tr>
                        <td class="border px-4 py-2">{{ $msg->fromuser ?? __('System') }}</td>
                        <td class="border px-4 py-2">{{ $msg->msgcontent }}</td>
                        <td class="border px-4 py-2">
                            {!! ($lastReadTime && $msg->dtime > $lastReadTime)
                                ? '<span class="text-red-600">' . $msg->dtime . '</span>'
                                : $msg->dtime !!}
                        </td>
                    </tr>
                @endforeach

                @foreach ($userMessages as $msg)
                    <tr>
                        <td class="border px-4 py-2">{{ $msg->fromuser ?? __('System') }}</td>
                        <td class="border px-4 py-2">{{ $msg->msgcontent }}</td>
                        <td class="border px-4 py-2">{{ $msg->dtime }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ url('/') }}" class="text-blue-500 hover:underline mt-4 inline-block">
            {{ __('Cancel') }}
        </a>
    </div>
@endsection
