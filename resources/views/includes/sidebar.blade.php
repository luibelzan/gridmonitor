<style>
    /* Prevent text color and underline change on hover */
    .sidebar a:hover {
        color: inherit !important;
        text-decoration: none !important;
    }




    .hover\:bg-custom:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(52 176 148 / var(--tw-bg-opacity));
    }




    .bg-custom {
        --tw-bg-opacity: 1;
        background-color: rgb(52 176 148 / var(--tw-bg-opacity));
    }




    .logo {
        display: block;
        width: 100%;
        height: auto;
        margin: 0 auto;
        /* Centrar horizontalmente la imagen */
    }




    .logo-mobile {
        display: none;
        /* Ocultar la imagen móvil por defecto */
    }




    @media (max-width: 767px) {
        .logo-desktop {
            display: none;




        }




        .logo-mobile {
            display: block;
            object-fit: contain;
            /* Controla cómo se ajusta la imagen dentro del contenedor */
            width: 40px;
            /* Ancho del logo en pantallas móviles */
            height: 40px;
            /* Altura del logo en pantallas móviles */
        }




        .sidebar {
            overflow-x: hidden;
            /* Evita el desbordamiento horizontal del sidebar */
        }
    }
</style>




<div class="top-0 fixed flex flex-col left-0 w-14 hover:w-64 md:w-64 h-full text-white transition-all duration-300 border-none z-10 sidebar"
    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
    <!-- Imagen -->
    <span class="inline-flex justify-center items-center ml-2 mt-12">




        {{-- <div class="py-4 px-4"> --}}
        <img src="../../images/Logo_4.png" alt="Logo" class="logo-desktop h-10 w-auto mx-auto">
        <img src="../../images/Logo_5.png" alt="Logo" class="logo-mobile h-8 w-auto mx-auto">
        {{-- </div> --}}
    </span>
    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow mt-12">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Menú</div>
                </div>
            </li>
            @if (auth()->check() && auth()->user()->hasRole('admin'))








                <li>
                    <a href="{{ route('registro') }}"
                        class=" relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:border-emerald-700 dark:hover:border-gray-800 pr-6
                        @if (Session::get('vista_actual') == 'registro') bg-custom @endif">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>








                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Registrar usuarios</span>
                    </a>
                    <a href="{{ route('admin') }}"
                        class="relative flex flex-row items-center h-11 focus:outline-none  dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:bg-custom dark:hover:border-gray-800 pr-6
                        @if (Session::get('vista_actual') == 'admin') bg-custom @endif">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Listado usuarios</span>
                    </a>
                </li>
            @else
                <li>
                    @if (Auth::check() && Auth::user()->ind_pf == true)
                        <a href="{{ route('informacionpf') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                @if (Session::get('vista_actual') == 'informacionpf' ||
                        Session::get('vista_actual') == 'dashboardpf' ||
                        Session::get('vista_actual') == 'reportespf' ||
                        Session::get('vista_actual') == 'curvashorariaspf' ||
                        Session::get('vista_actual') == 'curvascuartihorariaspf' ||
                        Session::get('vista_actual') == 'eventospf') bg-custom @endif">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    class="h-8 w-8 text-gray-100" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="5 9 2 12 5 15" />
                                    <polyline points="9 5 12 2 15 5" />
                                    <polyline points="15 19 12 22 9 19" />
                                    <polyline points="19 9 22 12 19 15" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                    <line x1="12" y1="2" x2="12" y2="22" />
                                </svg>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate ">Contadores Telemedida</span>
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check() && Auth::user()->ind_ct == true)
                        <a href="{{ route('informacionct') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                @if (Session::get('vista_actual') == 'informacionct' ||
                        Session::get('vista_actual') == 'energia' ||
                        Session::get('vista_actual') == 'dashboardct' ||
                        Session::get('vista_actual') == 'balances' ||
                        Session::get('vista_actual') == 'señalplc' ||
                        Session::get('vista_actual') == 'eventosct') bg-custom @endif">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <svg class="h-8 w-8 text-gray-100" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                                    </svg>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Centros de Transformación</span>
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check() && Auth::user()->ind_cups == true)
                        <a href="{{ route('informacioncups') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                @if (Session::get('vista_actual') == 'informacioncups' ||
                        Session::get('vista_actual') == 'detallesinformacioncups' ||
                        Session::get('vista_actual') == 'eventoscups' ||
                        Session::get('vista_actual') == 'detallesenergiacups' ||
                        Session::get('vista_actual') == 'energiacups' ||
                        Session::get('vista_actual') == 'detallescurvashorariascups' ||
                        Session::get('vista_actual') == 'curvashorariascups' ||
                        Session::get('vista_actual') == 'detalleseventoscups') bg-custom @endif">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" <svg
                                    class="h-8 w-8 text-gray-100" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <rect x="4" y="3" width="16" height="18" rx="2" />
                                    <rect x="8" y="7" width="8" height="3" rx="1" />
                                    <line x1="8" y1="14" x2="8" y2="14.01" />
                                    <line x1="12" y1="14" x2="12" y2="14.01" />
                                    <line x1="16" y1="14" x2="16" y2="14.01" />
                                    <line x1="8" y1="17" x2="8" y2="17.01" />
                                    <line x1="12" y1="17" x2="12" y2="17.01" />
                                    <line x1="16" y1="17" x2="16" y2="17.01" />
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Cups</span>
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check() && Auth::user()->ind_ct == true)
                        <a href="{{ route('reportes') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                    @if (Session::get('vista_actual') == 'reportes' || 
                    Session::get('vista_actual') == 'reportesinventario' || 
                    Session::get('vista_actual') == 'reportescurvashorarias' || 
                    Session::get('vista_actual') == 'reportescalidad') bg-custom @endif">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="h-6 w-6 text-gray-100" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Reportes</span>
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check() && Auth::user()->ind_ws == true)
                        <a href="{{ route('eventosespontaneos') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                            @if (Session::get('vista_actual') == 'eventosespontaneos') bg-custom @endif">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="h-6 w-6 text-slate-100"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                  </svg>
                                 
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Eventos espontáneos
                            </span>
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check() && Auth::user()->ind_sabt == true)
                        <a href="supervisionavanzada"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <svg class="h-8 w-8 text-gray-100" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg> </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Supervisión avanzada
                            </span>
                        </a>
                    @endif
                </li>
            @endif
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center mt-5 h-8">
                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Opciones</div>
                </div>
            </li>
































            <li>
                <a href="{{ route('profile.edit') }}"
                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                    @if (Session::get('vista_actual') == 'perfil') bg-custom @endif">
                    <span class="inline-flex justify-center items-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Perfil</span>
                </a>
            </li>
            {{-- <li>
                <a href="#"
                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Ajustes</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ route('contacto') }}"
                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-custom dark:hover:bg-gray-600 text-white-600 hover:text-gray-950 border-l-4 border-transparent hover:6 dark:hover:border-gray-800 pr-6
                    @if (Session::get('vista_actual') == 'contacto') bg-custom @endif">
                    <span class="inline-flex justify-center items-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <svg class="h-8 w-8 text-gray-100" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            </svg>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Contacto</span>
                </a>
            </li>
        </ul>
        {{-- <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs  font-light tracking-wide text-gray-400 ">
            <strong>CELNET COMUNICACIONES</strong><br>
            Calle Vendimiadoras 5, Polígono NOVAPARQ,
            Carriòn de los Céspedes, Sevilla, 41820.
            <br><br>
            <strong>TELÉFONOS</strong><br>
            Comercial: 641 427 208<br>
            Administración: 627 472 203
            <br><br>
            <strong>EMAIL</strong><br>
            comercial@celnet.es
        </p>
        --}}
    </div>
</div>
<!-- ./Sidebar -->




