@extends('layouts.app')
@section('content')
    <main class="min-h-screen py-6 mt-6">

        <h1 class="text-2xl font-bold">PostView for Group {{ $groupid }}</h1>
        {!! $domain_links !!}
        </br>
        <h3 class="flex items-center gap-4">
            <span>PostNumbers {{ $postnumbers }}</span>  <span>PosALLtNumbers {{ $postallnumbers }}</span>

            <form method="POST" action="{{ route('toggle.alist') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-md font-semibold shadow-sm transition-colors duration-200
                {{ $alist ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800' }}">
                    {{ $alist ? 'ALIST: ON' : 'ALIST: OFF' }}
                </button>
            </form>
        </h3>
 
        <ul>
            @foreach ($posts as $item)
                <li>

                    <a href="{{ $item['url'] }}">
                        {{ $item['title'] }}
                    </a> || by {{  $item['postaliasname'] }} || {{ $item['postdate']}}
                </li>
            @endforeach
        </ul>

    </main>

@endsection