{{--
@copyright (c) 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
@author Lican Huang
@created 2025-06-25
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
    <main class="min-h-screen py-6 mt-6">

        <h1 class="text-2xl font-bold">{{ $domaintitle }} ({{ $groupid }})</h1>
        <p>{{ $domaindescription }}</p>

        @if (session('message'))
            <div class="bg-green-100 text-green-800 p-2 rounded mt-2">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-4 mt-6">
            @if(isset($viewdomainposts))
                <form id="view-post-form" action="{{ $viewdomainposts->url }}" method="GET">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white text-lg font-medium rounded-xl shadow hover:bg-indigo-700 transition duration-200">
                        📄 {{ __('domain.viewpost') ?? 'View Domain Posts' }}
                    </button>
                </form>
            @endif

            @if(isset($createpost))
                <form id="create-post-form" action="{{ route('post.create', compact('groupid')) }}" method="GET">
                    @csrf
                    <input type="hidden" name="groupid" value="{{ $groupid }}">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-green-600 text-white text-lg font-medium rounded-xl shadow hover:bg-green-700 transition duration-200">
                        ✍️ {{ __('domain.createpost') ?? 'Create New Post' }}
                    </button>
                </form>
            @endif
        </div>
        {{-- Domain Directory Manage --}}
        <div class="border-b px-4 py-2 text-right">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <button @click="open = !open" @click.away="open = false"
                    class="inline-flex justify-center w-full px-3 py-1 font-medium bg-gray-100 rounded hover:bg-gray-200">
                    <span class="text-2xl">📁 {{ __('domain.manage') }}</span>
                    <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" x-transition x-cloak
                    class="absolute right-0 z-50 mt-2 w-48 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                    <a href="{{ route('domainview.createsub', ['groupid' => $groupid]) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ {{ __('domain.createsub') }}</a>
                    <a href="{{ route('domainview.editdomain', ['groupid' => $groupid]) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ {{ __('domain.editdomain') }}</a>
                    <form method="POST" action="{{ route('domainview.editrights', compact('groupid')) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-100">🛡️{{ __('domain.editrights') }}</button>
                    </form>
                    <form method="POST" action="{{ route('domainview.auditcheck', compact('groupid')) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-100">✔️
                            {{ __('domain.auditcheck') }} </button>
                    </form>
                    <form method="POST" action="{{ route('domainview.audituncheck', compact('groupid')) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-100">❌
                            {{ __('domain.audituncheck') }} </button>
                    </form>
                    <form method="POST" action="{{ route('domainview.trash', compact('groupid')) }}"
                        onsubmit="return confirm({{ __('domain.comfirmtrash') }});">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                            {{ __('domain.trashdomain') }} </button>
                    </form>
                    <form method="POST" action="{{ route('domainview.untrash', compact('groupid')) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-100">♻️
                            {{ __('domain.restoredomain') }} </button>
                    </form>
                    <form method="POST" action="{{ route('domainview.destroy', compact('groupid')) }}"
                        onsubmit="return confirm({{ __('domain.permanetdelete') }}  );">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-200">❌
                            {{ __('domain.deletedomain') }} </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Group Manage --}}
        <div class="border-b px-4 py-2 text-right">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <button @click="open = !open" @click.away="open = false"
                    class="inline-flex justify-center w-full px-3 py-2 text-2xl font-semibold bg-gray-100 rounded hover:bg-gray-200">
                    👥 {{ __('domain.group') }}
                    <svg class="w-5 h-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                @php
                    $groupActions = [
                        ['route' => 'groupmessage', 'label' => __('domain.broadcastmsg')],
                        ['route' => 'approvegroup', 'label' => __("domain.approvegroup")],
                        ['route' => 'invitegroup', 'label' => __("domain.invitegroup")],
                        ['route' => 'auditcheckgroup', 'label' => __("domain.auditcheckgroup")],
                        ['route' => 'unauditcheckgroup', 'label' => __("domain.audituncheckgroup")],
                    ];
                @endphp

                <div x-show="open" x-transition x-cloak
                    class="absolute right-0 z-50 mt-2 w-48 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                    @foreach ($groupActions as $action)
                        <form method="POST" action="{{ route('group.' . $action['route'], compact('groupid')) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                {{ $action['label'] }}
                            </button>
                        </form>
                    @endforeach
                </div>


            </div>
        </div>

        <h1 class="text-2xl font-bold mt-6">{{ __('domain.groupstatus') }}</h1>


        <p class="text-sm text-gray-700 mt-2 flex flex-wrap gap-x-4 gap-y-1">
            <span class="flex items-center">👤 {{ __('domain.joined') }}: {{ $joincounts['joinnumbers'] ?? 0 }}</span>
            <span class="flex items-center">⏳ {{ __('domain.pending') }}: {{ $joincounts['pendingUsers'] ?? 0 }}</span>
            <span class="flex items-center">🚫 {{ __('domain.blocked') }}: {{ $joincounts['blockedUsers'] ?? 0 }}</span>
        </p>

        {{-- Join/Leave Group --}}
        @if(auth()->check())
            @if(!auth()->user()->hasApplyJoinGroup($groupid))
                <form method="POST" action="{{ route('group.joingroup', $groupid) }}" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __("domain.joingroup") }} </button>
                </form>
            @else
                <form method="POST" action="{{ route('group.quitgroup', $groupid) }}" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">{{ __("domain.quitgroup") }} </button>
                </form>
            @endif
        @endif



        {{-- set pub/set private Group --}}
        @if(auth()->check())
            @if(!auth()->user()->withDomainPublicStatus($groupid))
                <form method="POST" action="{{ route('group.setprivate') }}" class="mt-2">
                    @csrf
                    <input type="hidden" name="groupid" value="{{ $groupid }}">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded"> {{ __("domain.setprivate") }} </button>
                </form>
            @else
                <form method="POST" action="{{ route('group.setpublic')}}" class="mt-2">
                    @csrf
                    <input type="hidden" name="groupid" value="{{ $groupid }}">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">{{ __("domain.setpublic") }} </button>
                </form>
            @endif
        @endif


        {{-- Breadcrumb --}}
        <div class="whitespace-nowrap inline-flex items-center space-x-2 mt-4">
            {!! $domainlinks !!}
            <span>({{ $groupid }})</span>
        </div>

        {{-- Subdomains --}}
        <h3 class="text-xl font-bold mt-6">{{ __("domain.subdomains") }} ({{ count($subdomain) }})</h3>
        <ul class="list-disc ml-6 mt-2">
            @foreach ($subdomain as $sub)
                <li>
                    <a href="{{ $sub['domainViewUrl'] }}" class="text-blue-600 hover:underline">
                        {{ $sub['title'] }} by {{ $sub['owner'] }}
                    </a> |
                    <a href="{{ $sub['subPostViewUrl'] }}" class="text-gray-600 hover:underline">View SubGroup Posts</a>
                </li>
            @endforeach
        </ul>

    </main>
@endsection