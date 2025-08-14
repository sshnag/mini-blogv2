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
				<section class="relative overflow-hidden">
					<div class="absolute inset-0 -z-10 opacity-20 bg-gradient-to-b from-indigo-200 via-purple-100 to-transparent"></div>
					<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
							<div>
								<h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">Share ideas. Connect with people.</h1>
								<p class="mt-4 text-lg text-gray-600">A clean, minimalist mini blog platform built with Laravel + Livewire. Write posts, like, comment, and manage everything with ease.</p>
								<div class="mt-8 flex items-center gap-3">
									@if (Route::has('login'))
										<a href="{{ route('login') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">Log in</a>
										<a href="{{ route('register') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-white text-gray-900 border border-gray-200 font-medium hover:bg-gray-50 transition-colors">Create account</a>
									@endif
								</div>
								<ul class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-700">
									<li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Live post feed</li>
									<li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Likes & comments</li>
									<li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Admin dashboard</li>
								</ul>
							</div>
							<div class="hidden lg:block">
								<div class="rounded-2xl border border-gray-200 shadow-sm overflow-hidden bg-white">
									<div class="p-6 border-b border-gray-100">
										<div class="h-4 w-32 bg-gray-200 rounded"></div>
									</div>
									<div class="p-6 space-y-4">
										<div class="h-3 w-2/3 bg-gray-100 rounded"></div>
										<div class="h-3 w-1/2 bg-gray-100 rounded"></div>
										<div class="h-40 w-full bg-gray-100 rounded-xl"></div>
										<div class="h-3 w-3/4 bg-gray-100 rounded"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>

			<footer class="py-10 text-center text-sm text-gray-500">
				{{ config('app.name', 'Mini Blog') }} · Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
			</footer>
		</div>
	</body>
</html>
