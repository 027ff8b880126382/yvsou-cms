
@extends('layouts.app')
@section('content')
    <main class="min-h-screen py-6 mt-6">

        <h1 class="text-2xl font-bold">Domain/Group ({{ $groupid }})</h1>

        <!-- Create new post -->

        @if(isset($viewdomainposts))

            <!-- Hidden form -->
            <form id="post-form" action="{{   $viewdomainposts->url }}" method="GET" class="mt-4">
                @csrf
                <input type="hidden" name="groupid" value="{{$groupid}}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ $viewdomainposts->title}}
                </button>
            </form>

        @endif
        <!-- Create new post -->

        @if(isset($createpost))

            <!-- Hidden form -->
            <form id="post-form" action="{{ route('post.create', compact('groupid')) }}" method="GET" class="mt-4">
                @csrf
                <input type="hidden" name="groupid" value="{{$groupid}}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ $createpost->title}}
                </button>
            </form>

        @endif

        <!-- domain manager -->

        </br>
        </br>
        <tr class="border-b">

            <td class="px-4 py-2 text-right">
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <button @click="open = !open" @click.away="open = false"
                        class="inline-flex justify-center w-full px-3 py-1 text-sm font-medium bg-gray-100 rounded hover:bg-gray-200">
                        Domain Group Manage Actions
                        <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute right-0 z-50 mt-2 w-40 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                        <a href="{{ route('domainview.createsub', ['groupid' => $groupid]) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Create sub domain</a>

                        <a href="{{ route('domainview.editsub', ['groupid' => $groupid]) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Edit sub somain</a>


                        <form method="POST" action="{{ route('domainview.setpub', compact('groupid'))}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                SEt Public Group </button>
                        </form>

                        <form method="POST" action="{{ route('domainview.setprivate', compact('groupid'))}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                SEt Private Group </button>
                        </form>


                        <form method="POST" action="{{ route('domainview.auditcheck', compact('groupid'))}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                audit checck </button>
                        </form>

                        <form method="POST" action="{{ route('domainview.audituncheck', compact('groupid'))}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                audit uncheck </button>
                        </form>


                        <form method="POST" action="{{ route('domainview.trash', compact('groupid'))}}"
                            onsubmit="return confirm('Are you sure you want to trash this post?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                Trash domain</button>
                        </form>
                        <form method="POST" action="{{ route('domainview.untrash', compact('groupid'))}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                unTrash domain</button>
                        </form>


                        <form method="POST" action="{{ route('domainview.destroy', compact('groupid'))}}"
                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                                Delete domain</button>
                        </form>

                    </div>
                </div>
            </td>
        </tr>
        </br>

        <!-- Group Stats -->

        <p>
            Joined Users: {{ $joincounts['joinnumbers']  }} |
            Pending: {{ $joincounts['pendingUsers']  }} |
            Blocked: {{ $joincounts['blockedUsers']  }}
        </p>

        <!-- Join Button -->
        @if (auth()->check() && !auth()->user()->withinGroup($groupid))
            <form method="POST" action="{{ route('group.join', $groupid) }}">
                @csrf
                <button type="submit">Join Domain Group</button>
            </form>
        @endif

        <!-- Breadcrumb -->

        <div class="whitespace-nowrap inline-flex items-center space-x-2">
            <span>ALL ></span>
            {!! $domainlinks !!}
            <span>({{ $groupid }})</span>
        </div>

        <!-- Subdomains -->
        <h3>Sub Domains ({{ count($subdomain)}})</h3>
        @foreach ($subdomain as $sub)

            <p>
            <div><a href="{!!  $sub['domainViewUrl'] !!}">{{   $sub['title']}} || by {{$sub['owner']}} </a> <a
                    href="{!! $sub['subPostViewUrl']  !!}"> View SubGroup Posts </a></div>
            </p>
        @endforeach



    </main>

@endsection