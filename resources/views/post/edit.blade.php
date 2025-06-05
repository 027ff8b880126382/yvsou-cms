@extends('layouts.app')

@section('content')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-3xl bg-white p-6 rounded-2xl shadow-lg">
    <h1 class="text-center text-2xl md:text-3xl font-bold text-gray-800 mb-6">
      Edit Post
    </h1>

    <form method="POST" action="{{ route('post.update') }}" enctype="multipart/form-data" class="space-y-5">
      @csrf
      <input type="hidden" name="groupid" value="{{ $groupid }}">
      <input type="hidden" name="postid" value="{{ $post->id }}">

      <!-- Title Input -->
      <div>
      <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
      <input type="text" id="title" name="title"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        value="{{ old('title', $post->post_title) }}" required>
      </div>

      <!-- Content Editor -->
      <div>
      <label for="editor" class="block text-sm font-medium text-gray-700">Content</label>
      <textarea id="ys_editor" name="content"
        class="mt-1 block w-full h-48 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required> {{ old('content', $post_content) }}  </textarea>
      </div>
      <!-- Include the file library modal near the editor -->
      <div id="fileLibraryModal"
      style="display:none; position:fixed; top:10%; left:10%; width:80%; height:80%; overflow:auto; background:white; border:1px solid #ccc; padding:10px; z-index:10000;">
      <button onclick="closeLibraryModal()" style="float:right;">Close</button>
      <h3>Select a file from the library</h3>
      <div id="fileLibraryList"></div>
      </div>
      <!-- Submit Button -->
      <div class="flex justify-end">
      <button type="submit"
        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Update Post
      </button>
      </div>
    </form>
    </div>
  </div>


@endsection

@push('styles')
  <script>window.shouldLoadEditor = true;</script>
  @vite('resources/css/editor.css')
@endpush
@push('scripts')
  <script>window.shouldLoadEditor = true;</script>
  @vite('resources/js/editor.js')
@endpush