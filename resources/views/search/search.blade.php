{{--
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-15
* License: Dual Licensed – GPLv3 or Commercial
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* As an alternative to GPLv3, commercial licensing is available for organizations
* or individuals requiring proprietary usage, private modifications, or support.
*
* Contact: yvsoucom@gmail.com
* GPL License: https://www.gnu.org/licenses/gpl-3.0.html
*/
--}}

 <form method="POST" action="{{ route('search.search') }}" class="max-w-md mx-auto space-y-6 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    @csrf

    <!-- Keyword Row -->
    <div class="space-y-2">
        <label for="keyword" class="block text-sm font-medium text-gray-600">{{ __('search.keywordsearch') }}</label>
        <div class="flex items-center gap-2">
            <input type="text" name="keyword" id="keyword" placeholder="{{ __('search.inputkeyword') }}"
                class="flex-1 p-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
            <button type="submit" name="action" value="keyword"
                class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                Go
            </button>
        </div>
    </div>

    @auth
    <!-- My Keyword Row -->
    <div class="space-y-2">
        <label for="mykeyword" class="block text-sm font-medium text-gray-600">{{ __('search.personalkeyword') }}</label>
        <div class="flex items-center gap-2">
            <input type="text" name="mykeyword" id="mykeyword" placeholder="{{ __('search.inputpersonalkeyword') }}"
                class="flex-1 p-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200">
            <button type="submit" name="action" value="mykeyword"
                class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                Go
            </button>
        </div>
    </div>
    @endauth

    <!-- Directory Row -->
    <div class="space-y-2">
        <label for="dir" class="block text-sm font-medium text-gray-600">{{ __('search.directorysearch') }}</label>
        <div class="flex items-center gap-2">
            <input type="text" name="dir" id="dir" placeholder="{{ __('search.inputdirectory') }}"
                class="flex-1 p-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200">
            <button type="submit" name="action" value="dir"
                class="px-5 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
                Go
            </button>
        </div>
    </div>

    @auth
    <div class="grid grid-cols-2 gap-4 mt-6">
        <!-- My All Directories Button -->
        <button type="submit" name="action" value="mydir"
            class="col-span-1 px-4 py-3 bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                <path fill-rule="evenodd" d="M8 11a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            {{ __('search.alldirectory') }}  
        </button>

        <!-- My All Groups Button -->
        <button type="submit" name="action" value="mygroup"
            class="col-span-1 px-4 py-3 bg-gradient-to-br from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
            </svg>
            {{ __('search.allgroup') }}   
    </div>
    @endauth
</form>