<section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
    <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-12 gap-4">
        <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900">Weekly Highlights</h1>
        <a href="{{ route('posts.list') }}" class="text-indigo-600 hover:text-indigo-800 text-base font-medium flex items-center transition-colors">
            Explore all articles
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Featured Post -->
        @if($posts->first())
        @php $featured = $posts->first(); @endphp
        <div class="lg:col-span-2 rounded-2xl overflow-hidden relative group aspect-[4/3] lg:aspect-auto">
            @if($featured->featured_image)
                <a href="{{ route('posts.show', $featured->slug) }}" class="block h-full">
                    <img src="{{ Storage::url($featured->featured_image) }}"
                         alt=""
                         class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                </a>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
            <div class="absolute bottom-8 left-8 right-8 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <time class="text-sm opacity-90">{{ $featured->published_at->format('M d, Y') }}</time>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold leading-tight mb-4">
                    <a href="{{ route('posts.show', $featured->slug) }}" class="hover:underline decoration-2 underline-offset-4">
                        {{ $featured->title }}
                    </a>
                </h2>
                <a href="{{ route('posts.show', $featured->slug) }}" class="inline-flex items-center font-medium group">
                    Read story
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- Side Cards -->
        <div class="flex flex-col gap-6">
            @foreach($posts->skip(1)->take(2) as $side)
            <div class="rounded-2xl p-6 bg-white border border-gray-100 shadow-sm hover:shadow-md transition-all h-full flex flex-col">
                <div>
                    <time class="text-xs font-medium text-gray-500 mb-2 block">{{ $side->published_at->format('M d, Y') }}</time>
                    <h3 class="text-lg font-bold leading-snug mb-3 text-gray-900">
                        <a href="{{ route('posts.show', $side->slug) }}" class="hover:underline decoration-1 underline-offset-4">
                            {{ $side->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-5 line-clamp-3">{{ Str::limit(strip_tags($side->content), 100 )}}</p>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('posts.show', $side->slug) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors group">
                        Continue reading
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
