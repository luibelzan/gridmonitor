<style>
    .welcome-message {
        animation: fadeIn 1s ease-in-out forwards;
        opacity: 0;
    }


    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }


    }
</style>





<x-app-layout >
    <body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center "
    style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(42,50,62));" id="top">
        <div class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center "
        style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27 32 38));" id="top">
            <div class=" shadow-sm overflow-hidden sm:rounded-lg mt-64">
                <div class="p-6 text-center" style="color: white">
                    <div>
                        @auth
                            <p class="text-lg  mb-10 welcome-message" style="font-size: 50px !important;">Bienvenido,
                                {{ auth()->user()->name }}</p>
                        @else
                            <p class="text-lg font-semibold welcome-message" style="font-size: 50px !important;">Bienvenido,
                                invitado
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>


<!-- Carga de scripts -->
<script>
    // Espera 2 segundos antes de redirigir
    setTimeout(function() {
        @if (Auth::check() && Auth::user()->ind_pf == true && Auth::user()->ind_ct == true)
            window.location.href = "{{ route('dashboardct') }}";
        @endif
        @if (Auth::check() && Auth::user()->ind_pf == true && Auth::user()->ind_ct == false)
            window.location.href = "{{ route('dashboardpf') }}";
        @endif
        @if (Auth::check() && Auth::user()->ind_pf == false && Auth::user()->ind_ct == true)
            window.location.href = "{{ route('dashboardct') }}";
        @endif
        @if (auth()->check() && auth()->user()->hasRole('admin'))
            window.location.href = "{{ route('admin') }}";
        @endif
    }, 2000); // 2000 milisegundos = 2 segundos
</script>
