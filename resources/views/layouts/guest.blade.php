<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Mini Blog') }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

		<!-- Scripts -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="font-sans antialiased bg-gray-50 text-gray-900">
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
		<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
			<!-- Left side illustration/brand -->
			<div class="hidden lg:flex bg-gradient-to-br from-indigo-100 via-purple-50 to-white">
				<div class="w-full flex items-center justify-center p-12">
					<div class="max-w-md">
						<a href="/" wire:navigate class="inline-flex items-center gap-3 mb-8">
							<div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
								</svg>
							</div>
							<span class="font-semibold text-lg">{{ config('app.name', 'Mini Blog') }}</span>
						</a>
						<h1 class="text-4xl font-extrabold text-gray-900">Welcome to a cleaner writing experience</h1>
						<p class="mt-4 text-gray-600">Join our minimalist mini blog. Share your ideas, connect through comments and likes, and manage your content with ease.</p>
						<ul class="mt-8 space-y-3 text-sm text-gray-700">
							<li class="flex items-center gap-2"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Fast authentication</li>
							<li class="flex items-center gap-2"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Modern UI</li>
							<li class="flex items-center gap-2"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Admin controls</li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Right side form slot -->
			<div class="flex items-center justify-center p-6 lg:p-12">
				<div class="w-full max-w-md">
					<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
						{{ $slot }}
					</div>
					<div class="mt-6 text-center text-xs text-gray-500">© {{ date('Y') }} {{ config('app.name', 'Mini Blog') }}</div>
				</div>
			</div>
		</div>
	</body>
</html>
