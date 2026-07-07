@php
    $escortsWithStories = \App\Models\Escort::whereHas('stories', function ($query) {
        $query->where('is_active', true);
    })->with([
                'stories' => function ($query) {
                    $query->where('is_active', true)->orderBy('created_at', 'asc');
                },
                'publications' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
        ->withMax('stories', 'created_at')
        ->orderByDesc('stories_max_created_at')
        ->get();
@endphp

@if($escortsWithStories->isNotEmpty())
    <section id="stories"
        class="bg-white dark:bg-black py-8 border-t border-b border-gray-200 dark:border-gray-800 transition-colors duration-300"
        x-data="storiesComponent(@js($escortsWithStories))">

        <div class="max-w-7xl mx-auto px-4 lg:px-8 relative flex items-center group/scroll">

            <!-- Left Arrow (Carousel) -->
            <button @click="scrollLeft"
                class="absolute left-0 lg:left-2 z-10 text-red-600 hover:scale-110 transition-transform bg-black/20 rounded-full p-1 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>

            <!-- Bubbles -->
            <div x-ref="scrollContainer"
                @mouseenter="stopAutoScroll"
                @mouseleave="startAutoScroll"
                class="flex items-center gap-6 overflow-x-auto no-scrollbar px-10 w-full scroll-smooth"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                <template x-for="(escort, index) in escorts" :key="escort.id">
                    <div class="flex flex-col items-center gap-2 min-w-fit cursor-pointer group" @click="openStory(index)">
                        <div class="relative p-1 rounded-full border-2 border-red-600 transition-transform group-hover:scale-105"
                            :class="{ 'border-gray-300': allStoriesSeen(index) }">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200">
                                <img :src="getProfilePhoto(escort)" :alt="escort.name" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <span class="!text-black dark:!text-white text-xs font-bold tracking-tight"
                            x-text="escort.name"></span>
                    </div>
                </template>
            </div>

            <!-- Right Arrow (Carousel) -->
            <button @click="scrollRight"
                class="absolute right-0 lg:right-2 z-10 text-red-600 hover:scale-110 transition-transform bg-black/20 rounded-full p-1 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

        </div>

        <!-- Full Screen Story Viewer -->
        <div x-show="showModal" x-transition.opacity.duration.300ms
            class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-0 md:p-4" style="display: none;">

            <!-- Close Button -->
            <button @click="closeModal"
                class="absolute top-4 right-4 text-white hover:text-red-600 z-[130] p-2 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Desktop Arrows (Outside Container) -->
            <button @click.stop="prevStory"
                class="hidden md:block absolute left-4 lg:left-32 z-[130] text-red-600 hover:text-white p-2 transition-all hover:scale-125">
                <svg class="w-16 h-16 drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click.stop="nextStory"
                class="hidden md:block absolute right-4 lg:right-32 z-[130] text-red-600 hover:text-white p-2 transition-all hover:scale-125">
                <svg class="w-16 h-16 drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <template x-if="currentEscort">
                <div
                    class="relative w-full h-full max-w-[450px] max-h-[90vh] mx-auto flex flex-col items-center justify-center p-0 md:p-4">

                    <!-- Main Media Card (Phone Style) -->
                    <div
                        class="relative w-full h-full bg-zinc-900 md:rounded-2xl overflow-hidden shadow-2xl border border-gray-800 flex flex-col justify-center">

                        <!-- PROGRESS BAR CONTAINER (Dedicated Layer) -->
                        <div class="absolute top-0 left-0 right-0 z-[110] px-2 pt-2 pointer-events-none">
                            <div class="flex gap-1.5 h-1.5 w-full">
                                <template x-for="(story, idx) in currentEscort.stories" :key="story.id">
                                    <!-- Use inline styles to force white track visibility -->
                                    <div class="h-full flex-1 rounded-full overflow-hidden shadow-sm"
                                        style="background-color: rgba(255, 255, 255, 0.35); backdrop-filter: blur(4px);">
                                        <div class="h-full transition-all duration-100 ease-linear shadow-[0_0_10px_rgba(220,38,38,1)]"
                                            :style="'width: ' + getProgress(idx) + '%; background-color: #dc2626 !important;'">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- HEADER INFO (Separate Layer, Below Progress) -->
                        <div
                            class="absolute top-4 left-0 right-0 z-[100] p-4 pt-6 bg-gradient-to-b from-black/60 to-transparent pointer-events-none">
                            <div class="flex items-center gap-3 pointer-events-auto cursor-pointer group" @click="goToPublication(currentEscort)">
                                <div
                                    class="w-10 h-10 rounded-full p-0.5 border-2 border-red-600 overflow-hidden bg-black shadow-md group-hover:scale-105 transition-transform">
                                    <img :src="getProfilePhoto(currentEscort)"
                                        class="w-full h-full object-cover rounded-full">
                                </div>
                                <div class="flex flex-col text-left">
                                    <h3 class="text-white text-sm font-bold shadow-black drop-shadow-md group-hover:text-red-500 transition-colors"
                                        x-text="currentEscort.name"></h3>
                                    <div class="flex items-center gap-2">
                                        <span class="text-white/90 text-xs shadow-black drop-shadow-md font-medium"
                                            x-text="currentEscort.city"></span>
                                        <span class="text-[10px] text-white/60">•</span>
                                        <span class="text-red-500 text-xs font-bold shadow-black drop-shadow-md uppercase"
                                            x-text="getTimeAgo(currentStory ? currentStory.created_at : null)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media -->
                        <div class="relative w-full h-full bg-black" style="position:relative;overflow:hidden;">

                            <!-- Image (always in DOM, shown via x-show) -->
                            <img x-show="currentStory && currentStory.media_type === 'image'"
                                :src="currentStory && currentStory.media_type === 'image' ? getStoryMedia(currentStory) : ''"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;">

                            <!-- Video container (always in DOM) -->
                            <div x-show="currentStory && currentStory.media_type === 'video'"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <video x-ref="videoPlayer"
                                    muted
                                    playsinline
                                    controlsList="nodownload"
                                    oncontextmenu="return false;"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    @ended="nextStory"
                                    @timeupdate="updateVideoProgress">
                                </video>
                                <!-- Watermark -->
                                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;z-index:10;">
                                    <div class="text-2xl md:text-3xl font-black uppercase tracking-widest drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)] select-none opacity-60 flex">
                                        <span class="text-red-500">CITAS</span>
                                        <span class="text-white">ESCORTS</span>
                                    </div>
                                </div>
                                <!-- Unmute/Mute Toggle Button -->
                                <button @click.stop="toggleMute" style="position:absolute;bottom:6rem;right:1rem;z-index:60;background:rgba(0,0,0,0.5);color:white;padding:0.5rem;border-radius:9999px;border:1px solid rgba(255,255,255,0.2);">
                                    <template x-if="isMuted">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" /></svg>
                                    </template>
                                    <template x-if="!isMuted">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /></svg>
                                    </template>
                                </button>
                            </div>
                        </div>




                        <!-- Badge -->
                        <div class="absolute bottom-8 left-0 right-0 p-4 flex justify-center z-40">
                            <div class="backdrop-blur-md px-6 py-3 rounded-xl shadow-lg border border-white/20 hover:scale-105 transition-transform max-w-[90%]"
                                style="background-color: #dc2626 !important;">
                                <span
                                    class="text-white font-bold text-xs uppercase tracking-wide text-center block whitespace-normal break-words leading-tight"
                                    x-text="currentStory && currentStory.caption ? currentStory.caption : 'Disponible por hoy...'"></span>
                            </div>
                        </div>

                        <!-- Touch Zones -->
                        <div class="absolute inset-0 z-30 flex">
                            <div class="w-1/3 h-full" @click="prevStory"></div>
                            <div class="w-1/3 h-full" @click="togglePause"></div>
                            <div class="w-1/3 h-full" @click="nextStory"></div>
                        </div>

                    </div>

                </div>
            </template>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('storiesComponent', (escortsData) => ({
                    escorts: escortsData,
                    showModal: false,
                    currentEscortIndex: 0,
                    currentStoryIndex: 0,
                    timer: null,
                    progress: 0,
                    duration: 5000,
                    startTime: 0,
                    paused: false,
                    autoScrollInterval: null,

                    isMuted: true,

                    startAutoScroll() {
                        this.stopAutoScroll();
                        this.autoScrollInterval = setInterval(() => {
                            const container = this.$refs.scrollContainer;
                            if (container) {
                                if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 5) {
                                    container.scrollTo({ left: 0, behavior: 'smooth' });
                                } else {
                                    container.scrollBy({ left: 160, behavior: 'smooth' });
                                }
                            }
                        }, 6000);
                    },

                    stopAutoScroll() {
                        if (this.autoScrollInterval) {
                            clearInterval(this.autoScrollInterval);
                            this.autoScrollInterval = null;
                        }
                    },
                    
                    toggleMute() {
                        this.isMuted = !this.isMuted;
                        if (this.$refs.videoPlayer) {
                            this.$refs.videoPlayer.muted = this.isMuted;
                        }
                    },

                    get currentEscort() {
                        return this.escorts[this.currentEscortIndex];
                    },

                    get currentStory() {
                        if (!this.currentEscort || !this.currentEscort.stories) return null;
                        return this.currentEscort.stories[this.currentStoryIndex];
                    },

                    init() {
                        this.escorts.forEach(escort => {
                            if (escort.stories) {
                                let flatStories = [];
                                escort.stories.forEach(story => {
                                    let paths = story.media_path;
                                    if (Array.isArray(paths)) {
                                        paths.forEach((p, i) => {
                                            let s = { ...story };
                                            s.media_path = p;
                                            s.id = `${story.id}_${i}`;
                                            let ext = p.split('.').pop().toLowerCase().split('?')[0];
                                            s.media_type = ['mp4', 'mov', 'avi', 'webm', 'ogg'].includes(ext) ? 'video' : 'image';
                                            console.log('[Story flat]', s.media_type, this.resolveUrl(p));
                                            flatStories.push(s);
                                        });
                                    } else if (typeof paths === 'string' && paths.length > 0) {
                                        let s = { ...story };
                                        let ext = paths.split('.').pop().toLowerCase().split('?')[0];
                                        s.media_type = ['mp4', 'mov', 'avi', 'webm', 'ogg'].includes(ext) ? 'video' : 'image';
                                        console.log('[Story string]', s.media_type, this.resolveUrl(paths));
                                        flatStories.push(s);
                                    }
                                });
                                escort.stories = flatStories;
                            }
                        });
                        this.startAutoScroll();
                    },

                    goToPublication(escort) {
                        if (escort && escort.publications && escort.publications.length > 0) {
                            window.location.href = '/publicacion/' + escort.publications[0].id;
                        }
                    },

                    getStoryThumb(escort) {
                        // For the main bubble (preview)
                        if (!escort || !escort.stories || escort.stories.length === 0) return '';
                        return this.resolveUrl(escort.stories[0].media_path);
                    },

                    getProfilePhoto(escort) {
                        // For the story header
                        if (!escort) return '';
                        if (escort.profile_photo) {
                            return this.resolveUrl(escort.profile_photo);
                        }
                        return 'https://ui-avatars.com/api/?name=' + escort.name + '&color=ec4899&background=fdf2f8';
                    },

                    getStoryMedia(story) {
                        if (!story) return '';
                        return this.resolveUrl(story.media_path);
                    },

                    resolveUrl(path) {
                        if (!path) return '';
                        if (Array.isArray(path)) path = path[0];
                        if (path.startsWith('http')) return path;
                        return '/storage/' + path;
                    },

                    getTimeAgo(dateString) {
                        if (!dateString) return '';
                        
                        const date = new Date(dateString);
                        const now = new Date();
                        const diffInSeconds = Math.floor((now - date) / 1000);
                        
                        if (diffInSeconds < 60) return 'HACE UNOS SEGUNDOS';
                        
                        const diffInMinutes = Math.floor(diffInSeconds / 60);
                        if (diffInMinutes < 60) return `HACE ${diffInMinutes} MINUTOS`;
                        
                        const diffInHours = Math.floor(diffInMinutes / 60);
                        if (diffInHours < 24) return `HACE ${diffInHours} HORAS`;
                        
                        return 'HACE 24 HORAS';
                    },

                    scrollLeft() {
                        this.$refs.scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
                    },

                    scrollRight() {
                        this.$refs.scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
                    },

                    openStory(index) {
                        this.currentEscortIndex = index;
                        this.currentStoryIndex = 0;
                        this.showModal = true;
                        this.startStory();
                    },

                    closeModal() {
                        this.showModal = false;
                        this.stopTimer();
                        if (this.$refs.videoPlayer) this.$refs.videoPlayer.pause();
                    },

                    startStory() {
                        this.stopTimer();
                        this.progress = 0;
                        this.paused = false;

                        if (this.currentStory && this.currentStory.media_type === 'video') {
                            this.$nextTick(() => {
                                const video = this.$refs.videoPlayer;
                                const url = this.getStoryMedia(this.currentStory);
                                console.log('[startStory] video ref:', video ? 'FOUND' : 'NOT FOUND');
                                console.log('[startStory] url:', url);
                                if (!video) {
                                    console.error('[startStory] $refs.videoPlayer is null! Retrying in 200ms...');
                                    setTimeout(() => {
                                        const v2 = this.$refs.videoPlayer;
                                        if (v2) {
                                            v2.src = url;
                                            v2.load();
                                            v2.muted = true;
                                            this.isMuted = true;
                                            v2.play().catch(e => console.error('[startStory-retry] play error:', e));
                                        } else {
                                            console.error('[startStory-retry] still no video ref!');
                                        }
                                    }, 200);
                                    return;
                                }
                                if (video.getAttribute('src') !== url) {
                                    video.src = url;
                                    video.load();
                                }
                                video.muted = true;
                                this.isMuted = true;
                                const p = video.play();
                                if (p !== undefined) {
                                    p.then(() => console.log('[startStory] play() OK - video is playing'))
                                     .catch(err => {
                                        console.error('[startStory] play() FAILED:', err.message);
                                        video.muted = true;
                                        video.play().catch(e2 => console.error('[startStory] muted retry failed:', e2.message));
                                    });
                                }
                            });
                        } else {
                            if (this.$refs.videoPlayer) {
                                this.$refs.videoPlayer.pause();
                                this.$refs.videoPlayer.removeAttribute('src');
                            }
                            this.startImageTimer();
                        }
                    },

                    startImageTimer() {
                        this.startTime = Date.now();
                        this.timer = setInterval(() => {
                            if (!this.paused) {
                                let elapsed = Date.now() - this.startTime;
                                this.progress = (elapsed / this.duration) * 100;
                                if (elapsed >= this.duration) {
                                    this.nextStory();
                                }
                            }
                        }, 50);
                    },

                    stopTimer() {
                        if (this.timer) clearInterval(this.timer);
                        this.timer = null;
                    },

                    togglePause() {
                        this.paused = !this.paused;
                        if (this.currentStory && this.currentStory.media_type === 'video') {
                            if (this.paused) {
                                this.$refs.videoPlayer.pause();
                            } else {
                                let playPromise = this.$refs.videoPlayer.play();
                                if (playPromise !== undefined) {
                                    playPromise.catch(error => {
                                        this.$refs.videoPlayer.muted = true;
                                        this.$refs.videoPlayer.play();
                                    });
                                }
                            }
                        } else {
                            if (this.paused) {
                            } else {
                                this.startTime = Date.now() - (this.progress / 100) * this.duration;
                            }
                        }
                    },

                    nextStory() {
                        if (!this.currentEscort || !this.currentEscort.stories) return;
                        if (this.currentStoryIndex < this.currentEscort.stories.length - 1) {
                            this.currentStoryIndex++;
                            this.startStory();
                        } else {
                            this.nextEscort();
                        }
                    },

                    prevStory() {
                        if (this.currentStoryIndex > 0) {
                            this.currentStoryIndex--;
                            this.startStory();
                        } else {
                            this.prevEscort();
                        }
                    },

                    nextEscort() {
                        if (this.currentEscortIndex < this.escorts.length - 1) {
                            this.currentEscortIndex++;
                            this.currentStoryIndex = 0;
                            this.startStory();
                        } else {
                            this.closeModal();
                        }
                    },

                    prevEscort() {
                        if (this.currentEscortIndex > 0) {
                            this.currentEscortIndex--;
                            this.currentStoryIndex = 0;
                            this.startStory();
                        } else {
                            this.closeModal();
                        }
                    },

                    getProgress(idx) {
                        if (idx < this.currentStoryIndex) return 100;
                        if (idx > this.currentStoryIndex) return 0;
                        return this.progress;
                    },

                    allStoriesSeen(index) {
                        return false;
                    },

                    updateVideoProgress(event) {
                        const video = event.target;
                        if (video.duration) {
                            this.progress = (video.currentTime / video.duration) * 100;
                        }
                    }
                }));
            });
        </script>

        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </section>
@endif