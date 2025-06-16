@extends('layouts.app') 
@section('content')
<main class="min-h-screen py-6 mt-6 text-left">

    <div class="w-full px-4"> <!-- Ensure content does not center -->
        <h1 class="text-2xl font-bold mb-4">PostView for Group {{ $groupid }}</h1>

        <div>{!! $domain_links !!}</div>

        <br>

        <div class="mb-4">
            <p>PostNumbers: {{ $postnumbers }}</p>
            <p>PostALLNumbers: {{ $postallnumbers }}</p>
        </div>

        <form method="POST" action="{{ route('toggle.alist') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2 rounded-md font-semibold shadow-sm transition-colors duration-200
                {{ $alist ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800' }}">
                {{ $alist ? 'ALIST: ON' : 'ALIST: OFF' }}
            </button>
        </form>

        <ul class="list-disc pl-6 mt-6 space-y-2">
            @foreach ($posts as $item)
                <li>
                    <a href="{{ $item['url'] }}" class="text-blue-600 hover:underline">
                        {{ $item['title'] }}
                    </a>
                    <span class="text-sm text-gray-600">
                        by {{ $item['postaliasname'] }} | {{ $item['postdate'] }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

</main>
@endsection
