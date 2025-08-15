<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Mini Blog') }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

		<!-- Styles -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="antialiased font-sans bg-gray-50">
		<div class="min-h-screen flex flex-col">
			<header class="border-b bg-white">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
					<a href="/" class="flex items-center gap-2">
						<div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
							</svg>
						</div>
						<span class="font-semibold text-gray-900">{{ config('app.name', 'Mini Blog') }}</span>
					</a>
					@if (Route::has('login'))
						<livewire:welcome.navigation />
					@endif
				</div>
			</header>

			<main class="flex-1">
				<!-- Hero Section -->
				<section class="relative overflow-hidden">
					<div class="absolute inset-0 -z-10 opacity-20 bg-gradient-to-b from-indigo-200 via-purple-100 to-transparent"></div>
					<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
							<div>
								<h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">Share ideas. Connect with people.</h1>
								<p class="mt-4 text-lg text-gray-600">A clean, minimalist mini blog platform. <br>Write posts, like, comment, and manage everything with ease.</p>
								<div class="mt-8 flex items-center gap-3">
									@if (Route::has('login'))
										@auth
											@php
												$user = Auth::user();
												$hasAuthorRole = $user->hasRole('author');
												$hasAdminRole = $user->hasRole('admin');
												$canCreatePosts = $hasAuthorRole || $hasAdminRole;
											@endphp
											
											@if($canCreatePosts)
												<a href="{{ route('posts.create') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
													<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
													</svg>
													Create Post
												</a>
											@else
												<span class="inline-flex items-center px-5 py-3 rounded-xl bg-gray-300 text-gray-600 font-medium cursor-not-allowed">
													<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
													</svg>
													Author Role Required
												</span>
											@endif
										@else
											<a href="{{ route('login') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">Log in</a>
											<a href="{{ route('register') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-white text-gray-900 border border-gray-200 font-medium hover:bg-gray-50 transition-colors">Create account</a>
										@endauth
									@endif
								</div>
							</div>
							<div class="hidden lg:block">
								<div class="relative">
									<div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur-lg opacity-25"></div>
									<div class="relative overflow-hidden rounded-xl bg-white shadow-xl">
										<div class="relative h-full">
											<img src="https://images.unsplash.com/photo-1720293315574-911411515624?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
												alt="Blogging illustration"
												class="w-full h-full object-contain"
												loading="lazy">
											<div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-600/10 mix-blend-multiply"></div>
											<div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent">
												<h3 class="text-white font-semibold">Your Ideas, Shared Beautifully</h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-- Featured Posts Section -->
				<section class="py-16 bg-white">
					<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div class="text-center mb-12">
							<h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Posts</h2>
							<p class="text-gray-600">Discover the latest content from our community</p>
						</div>

						<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
							@foreach(\App\Models\Post::published()->with('user')->withCount(['likes', 'approvedComments'])->latest()->take(3)->get() as $post)
								<article class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
									@if($post->featured_image)
										<a href="{{ route('posts.show', $post->slug) }}" class="block">
											<img src="{{ Storage::url($post->featured_image) }}"
												 alt="{{ $post->title }}"
												 class="w-full h-48 object-cover">
										</a>
									@endif

									<div class="p-6">
										<h3 class="text-xl font-semibold text-gray-900 mb-3">
											<a href="{{ route('posts.show', $post->slug) }}"
											   class="hover:text-indigo-600 transition-colors">
												{{ $post->title }}
											</a>
										</h3>

										<p class="text-gray-600 mb-4 line-clamp-3">
											{{ Str::limit($post->content, 120) }}
										</p>

										<div class="flex items-center justify-between text-sm text-gray-500">
											<span class="flex items-center">
												<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
													<path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
												</svg>
												{{ $post->user->name }}
											</span>
											<span>{{ $post->created_at->diffForHumans() }}</span>
										</div>

										<div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
											<div class="flex items-center space-x-4 text-sm text-gray-500">
												<span class="flex items-center">
													<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
														<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.54 0 3.04.99 3.57 2.36h.87C11.46 4.99 12.96 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
													</svg>
													{{ $post->likes_count }}
												</span>
												<span class="flex items-center">
													<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
														<path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
													</svg>
													{{ $post->approved_comments_count }}
												</span>
											</div>

											<a href="{{ route('posts.show', $post->slug) }}"
											   class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
												Read more →
											</a>
										</div>
									</div>
								</article>
							@endforeach
						</div>

						<div class="text-center mt-12">
							<a href="{{ route('posts.index') }}"
							   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
								View All Posts
								<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
								</svg>
							</a>
						</div>
					</div>
				</section>
			</main>
		</div>
	</body>
</html>
