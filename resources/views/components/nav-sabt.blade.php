
<style>
    /* PARA EL NAV */
        /* Estilos para .custom-nav */
        .custom-nav {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            margin: auto;
            /* Centra horizontalmente */
        }

        .custom-nav .nav-item {
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            font-weight: 500;
            position: relative;
        }

        .custom-nav .nav-item:before {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgb(88, 226, 194);
            border-radius: 8px 8px 0 0;
            opacity: 0;
            transition: .3s;
        }

        .custom-nav .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }

        .custom-nav .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            opacity: 1;
            bottom: 0;
        }

        .custom-nav .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
        }

        .custom-nav .nav-indicator {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            transition: .4s;
            height: 5px;
            z-index: 1;
            border-radius: 8px 8px 0 0;
        }

        @media (max-width: 600px) {
            .nav {
                flex-wrap: wrap;
                padding: 0;
                /* Elimina el padding horizontal en dispositivos móviles */
                border-radius: 2;
                /* Elimina el border-radius en dispositivos móviles */
                box-shadow: none;
                /* Elimina el box-shadow en dispositivos móviles */
            }

            .nav-item {
                flex: 1 0 40%;
                /* Mostrar en dos columnas */
                padding: 10px 0;
                /* Ajusta el padding para que se vea mejor en dispositivos móviles */
                text-align: center;
            }

            .nav-indicator {
                display: none;
                /* Oculta la barra indicadora en dispositivos móviles */
            }
        }
</style>

{{-- Botones de arriba --}}
<nav class="nav custom-nav mb-12">
    <a href="{{ route('dashboardsabt') }}" class="nav-item {{ Request::is('dashboard*') ? 'is-active' : '' }}"
        active-color="rgb(88, 226, 194)">Dashboard</a>
    <a href="{{ route('indicadoressabt') }}" class="nav-item {{ Request::is('indicadores*') ? 'is-active' : '' }}"
        active-color="rgb(88, 226, 194)">Indicadores</a>
    <a href="{{ route('supervisionavanzada') }}" class="nav-item {{ Request::is('supervisionavanzada') ? 'is-active' : '' }}"
        active-color="rgb(88, 226, 194)">Información</a>
    <a href="{{ route('fasessabt') }}" class="nav-item {{ Request::is('supervisionavanzada') ? 'is-active' : '' }}"
        active-color="rgb(88, 226, 194)">Fases</a>
    <a href="{{ route('fasessabt') }}" class="nav-item {{ Request::is('supervisionavanzada') ? 'is-active' : '' }}"
        active-color="rgb(88, 226, 194)">Calidad</a>
    <span class="nav-indicator"></span>
</nav>