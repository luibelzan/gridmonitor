



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
       


        /* Estilos adicionales para centrar el formulario en dispositivos móviles */
        @media (max-width: 640px) {
            .center-form {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
        }
    </style>
</head>




<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />




<form method="POST" action="{{ route('login') }}">
    @csrf
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <div
        class=" absolute top-0 left-0  via-gray-900 to-blue-800 bottom-0 leading-5 h-full w-full overflow-hidden" style="background: linear-gradient(to bottom, rgb(42,50,62), RGB(27 32 38));">




    <div class="relative   min-h-screen  sm:flex sm:flex-row  justify-center bg-transparent rounded-3xl shadow-xl center-form">
       
        <div class="flex justify-center self-center  z-10">
            <div class="p-12 bg-white mx-auto rounded-3xl w-96 ">
                {{-- imagen --}}
                <img src="{{ asset('images/Logo_2-ret1.png') }}" alt="Mi imagen personalizada"
                    style="max-width: 100%; height: auto;">
                <br>




                <div class="space-y-6">
                    <div class="">
                        {{-- <input
                        class=" w-full text-sm  px-4 py-3 bg-gray-200 focus:bg-gray-100 border  border-gray-200 rounded-lg focus:outline-none focus:border-purple-400"
                        type="" placeholder="Email"> --}}












                        <!-- Email Address -->
                        <div>
                            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
                            <input placeholder="Email"
                                class=" w-full text-sm  px-4 py-3 bg-gray-200 focus:bg-gray-100 border  border-gray-200 rounded-lg focus:outline-none focus:border-blue-900"
                                id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>




                    {{-- Contraseña --}}
                    <div class="relative" x-data="{ show: true }">
                        {{-- <input placeholder="Password" :type="show ? 'password' : 'text'"
                        class="text-sm text-gray-200 px-4 py-3 rounded-lg w-full bg-gray-200 focus:bg-gray-100 border border-gray-200 focus:outline-none focus:border-purple-400">
                    <div class="flex items-center absolute inset-y-0 right-0 mr-3  text-sm leading-5"> --}}




                        <input placeholder="Password" :type="show ? 'password' : 'text'"
                            class="text-sm text-black-200 px-4 py-3 rounded-lg w-full bg-gray-200 focus:bg-gray-100 border border-gray-200 focus:outline-none focus:border-blue-900"
                            id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <div class="flex items-center absolute inset-y-0 right-0 mr-3  text-sm leading-5">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <svg @click="show = !show" :class="{ 'hidden': !show, 'block': show }"
                                class="h-4 text-blue-900" fill="none" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 576 512">
                                <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                </path>
                            </svg>




                            <svg @click="show = !show" :class="{ 'block': !show, 'hidden': show }"
                                class="h-4 text-blue-900" fill="none" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                </path>
                            </svg>




                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-sm ml-auto">
                            <!-- Remember Me -->
                            <div class="block mt-3">
                                <label for="remember_me" class="inline-flex items-center" style="margin-top: -0.5rem;">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-900 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-900 dark:focus:ring-offset-gray-800"
                                        name="remember">
                                    <span class="ml-2 mr-2 text-sm text-blue-900 dark:text-gray-400">{{ __('Recuérdame') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                   




                        <x-primary-button
                            class="w-full flex justify-center bg-blue-900  hover:bg-emerald-700 text-gray-100 p-3  rounded-lg tracking-wide font-semibold  cursor-pointer transition ease-in duration-500">
                            {{ __('Iniciar sesión') }}
                        </x-primary-button>
                    </div>
                    <div class="flex items-center justify-center space-x-2 my-5">
                        <span class="h-px w-16 bg-gray-100"></span>




                        <span class="h-px w-16 bg-gray-100"></span>
                    </div>
                    <div class="flex justify-center gap-5 w-full ">




                    </div>
                </div>
                {{-- <div class="mt-7 text-center text-gray-300 text-xs">
                <span>
                    Copyright © 2021-2023
                    <a href="https://codepen.io/uidesignhub" rel="" target="_blank" title="Codepen aji"
                        class="text-purple-500 hover:text-purple-600 ">AJI</a></span>
            </div> --}}
            </div>
        </div>
    </div>
    </div>
</form>
<footer class="bg-transparent absolute w-full bottom-0 left-0 z-30">








</footer>




<svg class="absolute bottom-0 left-0 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    {{-- <path fill="#fff" fill-opacity="1"
        d="M0,0L40,42.7C80,85,160,171,240,197.3C320,224,400,192,480,154.7C560,117,640,75,720,74.7C800,75,880,117,960,154.7C1040,192,1120,224,1200,213.3C1280,203,1360,149,1400,122.7L1440,96L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
    </path> --}}
</svg>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>














