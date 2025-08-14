<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
	public string $name = '';
	public string $email = '';
	public string $password = '';
	public string $password_confirmation = '';

	/**
	 * Handle an incoming registration request.
	 */
	public function register(): void
	{
		$validated = $this->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
			'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
		]);

		$validated['password'] = Hash::make($validated['password']);

		event(new Registered($user = User::create($validated)));

		Auth::login($user);

		$this->redirect(route('dashboard', absolute: false), navigate: true);
	}
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
	<div class="w-full max-w-md bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
		<h1 class="text-2xl font-bold text-gray-900 mb-6">Create your account</h1>
		<form wire:submit="register" class="space-y-5">
			<!-- Name -->
			<div>
				<x-input-label for="name" :value="__('Name')" />
				<x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name"  autofocus autocomplete="name" />
				<x-input-error :messages="$errors->get('name')" class="mt-2" />
			</div>

			<!-- Email Address -->
			<div>
				<x-input-label for="email" :value="__('Email')" />
				<x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"  autocomplete="username" />
				<x-input-error :messages="$errors->get('email')" class="mt-2" />
			</div>

			<!-- Password -->
			<div>
				<x-input-label for="password" :value="__('Password')" />
				<x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
				<x-input-error :messages="$errors->get('password')" class="mt-2" />
			</div>

			<!-- Confirm Password -->
			<div>
				<x-input-label for="password_confirmation" :value="__('Confirm Password')" />
				<x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"  autocomplete="new-password" />
				<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
			</div>

			<div class="flex items-center justify-between">
				<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
					{{ __('Already registered?') }}
				</a>

				<x-primary-button>
					{{ __('Register') }}
				</x-primary-button>
			</div>
		</form>
	</div>
</div>
