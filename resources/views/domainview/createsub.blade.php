@extends('layouts.app')
@section('content')
    <main class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6">
            <form method="POST" action="{{ route('domainview.storesub') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="groupid" value="{{$groupid}}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Create Domain Titles & Descriptions</h2>

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($getlangSet as $code => $language)
                        <div class="space-y-3">
                            <label for="title-{{ $code }}" class="block text-sm font-medium text-gray-700">
                                {{ $language }} Domain Title
                            </label>
                            <input type="text" id="title-{{ $code }}" name="titles[{{ $code }}]"
                                placeholder="Title in {{ $language }}"
                                class="w-full rounded-lg border border-gray-300 p-2 focus:ring focus:ring-blue-300 focus:outline-none">

                            <label for="desc-{{ $code }}" class="block text-sm font-medium text-gray-700">
                                {{ $language }} Description
                            </label>
                            <textarea id="desc-{{ $code }}" name="descriptions[{{ $code }}]"
                                placeholder="Description in {{ $language }}" rows="3"
                                class="w-full rounded-lg border border-gray-300 p-2 focus:ring focus:ring-blue-300 focus:outline-none"></textarea>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </main>


@endsection