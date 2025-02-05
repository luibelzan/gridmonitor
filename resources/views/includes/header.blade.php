@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="https://unpkg.com/alpinejs@3.0.6/dist/cdn.min.js" defer></script>

<style>
    


    /* Custom style */
    .header-right {
        width: calc(100% - 3.5rem);
    }




    .sidebar:hover {
        width: 16rem;
    }




    @media only screen and (min-width: 768px) {
        .header-right {
            width: calc(100% - 16rem);
        }
    }
</style>
<!-- Header -->   

<div class="absolute top-0 right-0 flex items-center justify-between h-14 text-white z-10">
    {{-- <div class="hidden md:flex items-center justify-center w-14 md:w-64 h-14 border-none">
        <!-- Contenido dentro del primer div -->
    </div> --}}
    @include('includes/sidebar') 

    <div class="flex justify-between items-center h-14 header-right">
        <div class="rounded flex items-center max-w-xl mr-4 p-2"> 
            <!-- Contenido dentro del segundo div -->
        </div>
        <ul class="flex items-center">
            <li>
                <a href="#" class="flex items-center mr-4 hover:text-blue-100">
                    @include('layouts/navigation')
                </a>
            </li>
        </ul>
    </div>
</div>


<!-- ./Header -->






