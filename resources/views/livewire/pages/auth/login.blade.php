<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
	public LoginForm $form;

	/**
	 * Handle an incoming authentication request.
	 */
	public function login(): void
	{
		$this->validate();

		$this->form->authenticate();

		Session::regenerate();

		$this->redirectIntended(default: route('posts.index', absolute: false), navigate: true);
	}
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
	<div class="w-full max-w-md bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
		<h1 class="text-2xl font-bold text-gray-900 mb-6">Welcome back</h1>

		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<form wire:submit="login" class="space-y-5">
			<!-- Email Address -->
			<div>
				<x-input-label for="email" :value="__('Email')" />
				<x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" autofocus autocomplete="username" />
				<x-input-error :messages="$errors->get('form.email')" class="mt-2" />
			</div>

			<!-- Password -->
			<div>
				<x-input-label for="password" :value="__('Password')" />
				<x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
				<x-input-error :messages="$errors->get('form.password')" class="mt-2" />
			</div>

			<!-- Remember Me -->
			<label for="remember" class="inline-flex items-center">
				<input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
				<span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
			</label>

			<div class="flex items-center justify-between">
				@if (Route::has('password.request'))
					<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
						{{ __('Forgot your password?') }}
					</a>
				@endif

				<x-primary-button>
					{{ __('Log in') }}
				</x-primary-button>
			</div>
		</form>
	</div>
</div>
