@extends('layouts.app')

@section('content')


    <form id="copypostlink" method="POST" action="{{route('post.movelangupdate', compact('groupid', 'pid')) }}">
        @csrf
        @method('PATCH')
        <div>

            <input type="hidden" name="groupid" value="{{ $groupid }}">
            <input type="hidden" name="pid" value="{{ $pid }}">



            <!-- Language Dropdown -->
            <div>
                <label for="language" class="block mb-2 text-sm font-medium text-gray-700">Select Language</label>
                <select name="language" id="language" class="border-gray-300 rounded-md shadow-sm">
                    @foreach ($langIdSet as $item)
                        <option value="{{ $item['langid'] }}" >
                            {{ $item['language']}}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
        </br>

        </br>
        <div class="flex justify-end">

            <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                move post to target language
            </button>
        </div>
        </div>
    </form>

@endsection