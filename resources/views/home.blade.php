 
{{-- resources/views/home.blade.php --}}
@extends('layouts.app')
@section('content')
    <div class="p-6 text-gray-900">
        @include('search')
        @include('newpage')
        @include('newdir')
    </div>
@endsection