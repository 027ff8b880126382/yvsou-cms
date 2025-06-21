
 
    <header class="w-full bg-white border-b shadow-sm fixed top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}">
                        <img class="h-8 w-auto" src="{{ asset('images/yvsoulogo.svg') }}" alt="Logo">
                    </a>
                </div>

                <!-- Hamburger Button (mobile) -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <nav class="hidden md:flex items-center gap-4">
                    <!-- Right: Nav Links -->

                    <div class="flex items-center gap-4">
                        <!-- Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <!-- Trigger button -->
                            <button @click="open = !open"
                                class="px-4 py-2 bg-gray-200 rounded inline-flex items-center">
                                🌐 <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.25 7L10 11.75 14.75 7z" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 z-10 mt-2 w-32 bg-white border rounded shadow-md" x-transition>
                                @foreach ($getlangSet as $code => $language)
                                    <a href="{{ url('lang/' . $code) }}"
                                        class="block px-4 py-2 hover:bg-gray-100 {{ app()->getLocale() === $code ? 'font-bold text-blue-600' : '' }}">
                                        {{ $language }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('domainview.index', ['groupid' => 0]) }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">

                            {{ __('header.rootdomaintool') }}
                        </a>
                        <a href="{{ route('help') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            {{ __('header.help') }}
                        </a>
                        @if (Route::has('login'))

                            @auth

                                <!-- Dropdown -->


                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md">
                                            <span class="mr-2">{{ Auth::user()->name }}</span>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Profile -->
                                        <a href="{{ route('admin.profile.edit') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('profile.title') }}
                                        </a>
                                        <!-- Dashboard -->
                                        <a href="{{ route('dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('dashboard.dashboard') }}
                                        </a>

                                        <!-- Logout -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ __('auth.logout') }}
                                            </button>
                                        </form>
                                    </x-slot>
                                </x-dropdown>

                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                    {{ __('auth.login') }}
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                        {{ __('auth.register') }}
                                    </a>
                                @endif
                            @endauth

                        @endif

                        <a href="{{ route('message.index') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            {{ __('message.message') }}
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Mobile Menu (hidden by default) -->
        <div id="mobile-menu" class="md:hidden hidden px-4 pt-2 pb-4 bg-white border-t">
            <!-- Dropdown -->
            <div class="absolute left-0 z-10 hidden mt-2 w-32 bg-white border rounded shadow-md group-hover:block">
                @foreach ($getlangSet as $code => $language)
                    <a href="{{ url('lang/' . $code) }}"
                        class="block px-4 py-2 hover:bg-gray-100 {{ app()->getLocale() === $code ? 'font-bold text-blue-600' : '' }}">
                        {{ $language }}
                    </a>
                @endforeach

            </div>
            <a href="{{ route('domainview.index', ['groupid' => 0]) }}"
                class="block py-2 text-sm text-gray-700 hover:text-black">

                {{ __('header.rootdomaintool') }}
            </a>
            <a href="{{ route('help') }}" class="block py-2 text-sm text-gray-700 hover:text-black">
                {{ __('header.help') }}</a>
            <a href="{{ route('message.index') }}" class="block py-2 text-sm text-gray-700 hover:text-black">
                {{ __('message.message') }}</a>

            @if (Route::has('login'))
                @auth
                    <!-- Dropdown -->


                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Profile -->
                            <a href="{{ route('admin.profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('profile.title') }}
                            </a>
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('dashboard.dashboard') }}
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('auth.logout') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>


                @else
                    <a href="{{ route('login') }}"
                        class="block py-2 text-sm text-gray-700 hover:text-black">{{ __('auth.login') }} </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block py-2 text-sm text-gray-700 hover:text-black">{{ __('auth.register') }} </a>
                    @endif
                @endauth
            @endif
        </div>

        <script>
            document.getElementById('mobile-menu-button').addEventListener('click', function () {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        </script>
    </header>