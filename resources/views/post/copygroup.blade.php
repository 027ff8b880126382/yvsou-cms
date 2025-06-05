@extends('layouts.app')

@section('content')


    <form id="copypostlink" method="POST" action="{{route('post.copygroupupdate', compact('groupid', 'pid')) }}">
        @csrf
        @method('PATCH')
        <div>
            <label for="editor" class="block text-sm font-medium text-gray-700">target groupid</label>
            <input type="text" name="desgroupid" value="" size="30" maxlength="350">
            <input type="hidden" name="groupid" value="{{ $groupid }}">
            <input type="hidden" name="pid" value="{{ $pid }}">

            </br>

            </br>
            <div class="flex justify-end">

                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    copy post to target group
                </button>
            </div>
        </div>
    </form>

@endsection