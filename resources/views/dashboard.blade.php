<x-main-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                    <p>Has iniciado sesión correctamente.</p>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
