
 
<footer class="w-full bg-gray-100 text-gray-800 py-4">

    <div class="mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center">
        <!-- Left: Copyright -->
        <div class="mb-2 sm:mb-0">
            &copy; {{ date('Y') }} {{ __('footer.copyright', ['app' => config('app.name')]) }} &nbsp;&nbsp;
           
        </div>

        <!-- Right: Links -->
        <div class="flex flex-col sm:flex-row sm:space-x-6 sm:justify-end space-y-2 sm:space-y-0">
            <a href="{{ route('about') }}" class="text-sm hover:text-gray-600">{{ __('footer.about') }}</a>
            <a href="{{ route('contact') }}" class="text-sm hover:text-gray-600">{{ __('footer.contact') }}</a>
            <a href="{{ route('terms') }}" class="text-sm hover:text-gray-600">{{ __('footer.terms') }}</a>
            <a href="{{ route('privacy') }}" class="text-sm hover:text-gray-600">{{ __('footer.privacy') }}</a>
        </div>
    </div>
</footer>

 