<x-main-layout>
    <x-slot:title>
        Mi Escritorio - Citasescort
        </x-slot>

        <div class="min-h-screen bg-gray-50 dark:bg-black pt-28 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Welcome Header -->
                <div
                    class="mb-12 relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 shadow-xl shadow-gray-200/50 dark:shadow-black/50 p-8 md:p-12">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand-pink/10 text-brand-pink text-xs font-bold uppercase tracking-wide">
                                    Usuario
                                </span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                Hola, <span class="text-brand-pink">{{ Auth::user()->name }}</span> 👋
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-xl">
                                Bienvenido a tu espacio personal. Aquí puedes gestionar tus favoritos y explorar nuevas
                                experiencias.
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-right hidden md:block">
                                <span
                                    class="block text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->favorites->count() }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Favoritas</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="group flex items-center justify-center w-12 h-12 rounded-full border border-gray-200 dark:border-zinc-700 hover:bg-red-50 dark:hover:bg-red-900/10 hover:border-red-200 dark:hover:border-red-900/30 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="text-gray-500 dark:text-gray-400 group-hover:text-red-500 transition-colors">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" x2="9" y1="12" y2="12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Background decoration -->
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-brand-pink/5 rounded-full blur-3xl pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-purple-500/5 rounded-full blur-3xl pointer-events-none">
                    </div>
                </div>

                <!-- Content -->
                <div x-data="{ tab: 'favorites' }" class="space-y-8">
                    @if(session('success'))
                        <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded relative"
                            role="alert">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Tabs -->
                    <div
                        class="flex items-center gap-2 border-b border-gray-200 dark:border-zinc-800 pb-1 overflow-x-auto">
                        <button @click="tab = 'favorites'"
                            class="px-6 py-3 text-sm font-bold rounded-t-lg transition-all relative flex items-center gap-2 whitespace-nowrap"
                            :class="tab === 'favorites' ? 'text-brand-pink bg-white dark:bg-zinc-900 border-b-2 border-brand-pink' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-800/50'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" :class="tab === 'favorites' ? 'fill-current' : ''">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg>
                            Mis Favoritos
                        </button>

                        <button @click="tab = 'reviews'"
                            class="px-6 py-3 text-sm font-bold rounded-t-lg transition-all relative flex items-center gap-2 whitespace-nowrap"
                            :class="tab === 'reviews' ? 'text-brand-pink bg-white dark:bg-zinc-900 border-b-2 border-brand-pink' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-800/50'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                </polygon>
                            </svg>
                            Mis Reseñas
                        </button>

                        <button @click="tab = 'profile'"
                            class="px-6 py-3 text-sm font-bold rounded-t-lg transition-all relative flex items-center gap-2 whitespace-nowrap"
                            :class="tab === 'profile' ? 'text-brand-pink bg-white dark:bg-zinc-900 border-b-2 border-brand-pink' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-800/50'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Mi Perfil
                        </button>
                    </div>

                    <!-- Favorites Grid -->
                    <div x-show="tab === 'favorites'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                        @if(Auth::user()->favorites->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach(Auth::user()->favorites as $escort)
                                    <x-escort-card :escort="$escort" />
                                @endforeach
                            </div>
                        @else
                            <div
                                class="flex flex-col items-center justify-center py-24 bg-white dark:bg-zinc-900 rounded-3xl border border-dashed border-gray-200 dark:border-zinc-800">
                                <div
                                    class="w-20 h-20 bg-gray-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-6">
                                    <svg class="h-10 w-10 text-gray-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No tienes favoritos aún
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm mb-8">
                                    Explora nuestro catálogo de escorts y guarda las que más te gusten para encontrarlas
                                    fácilmente aquí.
                                </p>
                                <a href="{{ route('escorts.index') }}"
                                    class="inline-flex items-center px-8 py-3 rounded-full bg-brand-pink text-white font-bold hover:bg-brand-pink/90 hover:shadow-lg hover:shadow-brand-pink/30 transition-all transform hover:-translate-y-1">
                                    Explorar Escorts
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Reviews List -->
                    <div x-show="tab === 'reviews'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                        @if(Auth::user()->reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach(Auth::user()->reviews as $review)
                                    <div x-data="{ editing: false, rating: {{ $review->rating }} }"
                                        class="bg-white dark:bg-zinc-900 p-6 rounded-lg border border-gray-100 dark:border-zinc-800 shadow-sm relative">

                                        <!-- Display Mode -->
                                        <div x-show="!editing">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h4 class="text-gray-900 dark:text-white font-bold">
                                                        Para: <a href="{{ route('profile.show', $review->escort->id) }}"
                                                            class="text-brand-pink hover:underline">{{ $review->escort->name }}</a>
                                                    </h4>
                                                    <div class="flex text-red-500 text-sm my-1">
                                                        @for($i = 0; $i < $review->rating; $i++)
                                                            ★
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button @click="editing = true"
                                                        class="text-gray-400 hover:text-blue-500 transition-colors"
                                                        title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('user.reviews.destroy', $review->id) }}"
                                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reseña?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-gray-400 hover:text-red-500 transition-colors"
                                                            title="Eliminar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $review->content }}</p>
                                            <span class="text-xs text-gray-400 block mt-2">Publicado el
                                                {{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>

                                        <!-- Edit Mode -->
                                        <div x-show="editing" class="space-y-4">
                                            <form method="POST" action="{{ route('user.reviews.update', $review->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label
                                                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Puntaje</label>
                                                    <input type="number" name="rating" min="1" max="5"
                                                        value="{{ $review->rating }}"
                                                        class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-2 text-gray-900 dark:text-white"
                                                        required>
                                                </div>

                                                <div class="mb-4">
                                                    <label
                                                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Comentario</label>
                                                    <textarea name="content" rows="3"
                                                        class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-2 text-gray-900 dark:text-white"
                                                        required>{{ $review->content }}</textarea>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="editing = false"
                                                        class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancelar</button>
                                                    <button type="submit"
                                                        class="bg-brand-pink text-white px-4 py-2 rounded hover:bg-brand-pink/90">Guardar
                                                        Cambios</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                No has escrito reseñas todavía.
                            </div>
                        @endif
                    </div>

                    <!-- Profile Settings -->
                    <div x-show="tab === 'profile'"
                        class="animate-in fade-in slide-in-from-bottom-4 duration-500 max-w-2xl mx-auto">
                        <div
                            class="bg-white dark:bg-zinc-900 p-8 rounded-lg border border-gray-100 dark:border-zinc-800 shadow-sm mb-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Editar Datos Personales
                            </h3>

                            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label
                                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nombre</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                        class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-brand-pink">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-brand-pink">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="border-t border-gray-200 dark:border-zinc-800 pt-4 mt-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Cambiar
                                        Contraseña (Opcional)</h4>

                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Contraseña
                                                Actual</label>
                                            <input type="password" name="current_password"
                                                class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-brand-pink">
                                            @error('current_password') <span
                                            class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nueva
                                                    Contraseña</label>
                                                <input type="password" name="new_password"
                                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-brand-pink">
                                                @error('new_password') <span
                                                class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Confirmar
                                                    Nueva Contraseña</label>
                                                <input type="password" name="new_password_confirmation"
                                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-brand-pink">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 text-right">
                                    <button type="submit"
                                        class="bg-brand-pink hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg shadow-brand-pink/20">
                                        Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Delete Account -->
                        <div
                            class="bg-red-50 dark:bg-red-900/10 p-8 rounded-lg border border-red-200 dark:border-red-900/30">
                            <h3 class="text-xl font-bold text-red-600 dark:text-red-400 mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                                Zona de Peligro
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                Si eliminas tu cuenta, perderás todos tus favoritos y reseñas. Esta acción no se puede
                                deshacer.
                            </p>

                            <form method="POST" action="{{ route('user.account.destroy') }}"
                                onsubmit="return confirm('ATENCIÓN: ¿Estás seguro de que quieres eliminar tu cuenta permanentemente? Esta acción es irreversible.');">
                                @csrf
                                @method('DELETE')
                                <div class="flex items-center gap-4">
                                    <input type="password" name="password" placeholder="Tu contraseña actual"
                                        class="flex-1 bg-white dark:bg-black border border-red-200 dark:border-red-900/30 rounded px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-red-500"
                                        required>
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded transition-colors whitespace-nowrap">
                                        Eliminar Cuenta
                                    </button>
                                </div>
                                @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-main-layout>