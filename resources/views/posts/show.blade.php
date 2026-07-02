<x-main-layout>
    <!-- Article Header -->
    <div class="relative w-full h-[60vh] min-h-[400px] flex flex-col justify-end bg-cover bg-center" style="background-image: url('{{ $post->image ? (Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image)) : asset('images/bnerr.jpg') }}');">
        <div class="relative z-10 w-full p-8 lg:p-16">
            <div class="max-w-4xl mx-auto">
                <span
                    class="inline-block px-3 py-1 bg-brand-pink text-white text-xs font-bold uppercase tracking-wider rounded-full mb-4 shadow-lg shadow-brand-pink/30">
                    Actualidad
                </span>
                <h1 class="text-4xl lg:text-5xl font-bold text-brand-pink mb-4 leading-tight drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)] bg-black/40 inline-block px-4 py-2 rounded-lg">
                    {{ $post->title }}
                </h1>
                <div class="flex items-center gap-4 text-brand-pink font-semibold text-sm bg-black/40 inline-flex px-4 py-2 rounded-lg mt-2">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-pink" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $post->published_at ? $post->published_at->format('d F, Y') : 'Reciente' }}
                    </div>
                    <span>•</span>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-pink" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $post->user ? $post->user->name : 'Admin' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="bg-black text-gray-300 py-16 lg:py-24">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <div
                class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-brand-pink prose-a:no-underline hover:prose-a:underline">
                {!! $post->content !!}
            </div>

            <!-- Share / Tags -->
            <div class="mt-12 pt-12 border-t border-zinc-800 flex justify-between items-center">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center text-gray-400 hover:text-white transition-colors gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Noticias
                </a>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($recentPosts->count() > 0)
        <div class="bg-zinc-900 py-16">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <h3 class="text-2xl font-bold text-white mb-8">También te puede interesar</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentPosts as $related)
                        <a href="{{ route('posts.show', $related->slug) }}" class="group block">
                            <div class="relative h-48 rounded-xl overflow-hidden mb-4">
                                <img src="{{ Str::startsWith($related->image, 'http') ? $related->image : asset('storage/' . $related->image) }}" alt="{{ $related->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            <h4 class="text-lg font-bold text-white group-hover:text-brand-pink transition-colors">
                                {{ $related->title }}
                            </h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-main-layout>