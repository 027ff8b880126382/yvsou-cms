@extends('layouts.app')
@section('content')
    <main class="min-h-screen py-6 mt-6">
  
<form method="POST" action="{{ route('domainview.storesub') }}">
    @csrf

    <div>
      <label>English Title:</label>
      <input type="text" name="titles[en]" placeholder="Title in English">
      <textarea name="descriptions[en]" placeholder="Description in English"></textarea>
    </div>

    <div>
      <label>Chinese Title:</label>
      <input type="text" name="titles[zh]" placeholder="Title in Chinese">
      <textarea name="descriptions[zh]" placeholder="Description in Chinese"></textarea>
    </div>

    <!-- Add more languages as needed -->

    <button type="submit">Submit</button>
</form>


    </main>

@endsection