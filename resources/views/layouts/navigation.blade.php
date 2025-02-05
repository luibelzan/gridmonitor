  {{-- <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Logo_2-ret1.png') }}" alt="Mi imagen personalizada" style="max-width: 100%; height: auto; width: 90px;">                    </a>
                </div>
































                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>
































            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
































                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
































                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
































                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
































                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Salir') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
































            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-custom dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
































    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
































        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
































            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
































                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
































                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}
















@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>








<style>
    .bg-custom {
        --tw-bg-opacity: 1;
        background-color: rgb(52 176 148 / var(--tw-bg-opacity));
    }
</style>








<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    {{-- <div class="max-w-xs mx-auto px-2 sm:px-4 lg:px-6">
      <div class="flex justify-between h-16"> --}}
    {{-- <div class="flex">
              <!-- Logo -->
              {{-- <div class="shrink-0 flex items-center">
                  <a href="{{ route('dashboard') }}">
                      <img src="{{ asset('images/Logo_2-ret1.png') }}" alt="Mi imagen personalizada" style="max-width: 100%; height: auto; width: 90px;">
                  </a>
              </div> --}}
































































    <!-- Navigation Links -->
    {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                  <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                      {{ __('Dashboard') }}
                  </x-nav-link>
              </div> --}}
    {{-- </div> --}}




    <!-- Dropdown menu -->
    <div class="flex items-center">
        <div class="relative">
            <button @click="open = !open"
                class="flex items-center text-sm text-gray-50 dark:text-white ml-2 hover:text-gray-900 hover:bg-custom dark:hover:text-white dark:hover:bg-gray-700 rounded-lg p-2">
                {{-- <svg class="h-6 w-6 text-gray-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg> --}}




                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32"><path fill="#ffffff" d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5"/><path fill="#ffffff" d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2m7.993 22.926A5 5 0 0 0 19 20h-6a5 5 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0"/></svg>
                <span class="text-sm text-gray-50 dark:text-white ml-2">{{ Auth::user()->name }}</span>
            </button>
            <div x-show="open" @click.away="open = false"
    class="origin-top-right absolute right-0 mt-2 mr-2 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
    id="dropdown" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
    <!-- Dropdown content -->
    <div class="py-3 px-4">
        <p class="block text-sm font-semibold text-gray-50 dark:text-white"
           style="text-decoration: none; cursor: default;"
           onmouseover="this.style.textDecoration='none';"
           onmouseout="this.style.textDecoration='none';">
           Hola, {{ Auth::user()->name }}
        </p>
        <p class="block text-sm text-gray-50 dark:text-white"
           style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px; text-decoration: none; cursor: default;"
           onmouseover="this.style.textDecoration='none';"
           onmouseout="this.style.textDecoration='none';">
           {{ Auth::user()->email }}
        </p>
    </div>
    <ul class="py-1 text-gray-50 dark:text-gray-50" aria-labelledby="dropdown">
        <li>
            <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-sm hover:bg-custom"
                style="text-decoration: none; color: inherit;">Mi perfil</a>
        </li>
    </ul>


    <ul class="py-1 text-gray-50 dark:text-gray-50" aria-labelledby="dropdown">
        <li>
            <form method="POST" action="{{ route('logout') }}"
                class="block py-2 px-4 text-sm hover:bg-custom dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                @csrf
                <button type="submit">Salir</button>
            </form>
        </li>
    </ul>
</div>


        </div>
    </div>




    {{-- </div>
  </div> --}}
</nav>















