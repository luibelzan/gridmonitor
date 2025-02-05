<x-app-layout>
    <div class="py-12" style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27, 32, 38));">

        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white ">
            @include('includes/header')

            <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
                <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                    <!-- Content -->
                    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
