<x-main-layout>
    <!-- Header -->
    <div class="bg-zinc-900 border-b border-zinc-800 py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Blog & Noticias</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Mantente al dÃ­a con las últimas novedades, eventos y consejos de Citasescort.
            </p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="bg-black min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article
                        class="bg-zinc-900 rounded-2xl overflow-hidden hover:shadow-2xl hover:shadow-brand-pink/10 transition-all duration-300 group border border-zinc-800 hover:border-brand-pink/30">
                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative h-64 overflow-hidden">
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-60 group-hover:opacity-20 transition-opacity duration-500"></div>
                        </a>
                        <div class="p-6">
                            <div
                                class="flex items-center gap-2 text-xs text-brand-pink font-semibold uppercase tracking-wider mb-3">
                                <span class="w-2 h-2 rounded-full bg-brand-pink"></span>
                                {{ $post->published_at ? $post->published_at->format('d M, Y') : 'Reciente' }}
                            </div>
                            <h2
                                class="text-xl font-bold text-white mb-3 group-hover:text-brand-pink transition-colors line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-gray-400 text-sm line-clamp-3 leading-relaxed mb-4">
                                {{ Str::limit($post->content, 120) }}
                            </p>
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="inline-flex items-center text-sm font-medium text-white group-hover:text-brand-pink transition-colors">
                                Leer más
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-main-layout>
