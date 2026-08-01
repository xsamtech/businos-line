<x-guest-layout>
    <div class="mb-4 text-sm leading-6 text-gray-600">{{ __('messages.forgot_password_help') }}</div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}">@csrf<div><x-input-label for="email" :value="__('messages.email')"/><x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus/><x-input-error :messages="$errors->get('email')" class="mt-2"/></div><div class="mt-4 flex justify-end"><x-primary-button>{{ __('messages.send_reset_code') }}</x-primary-button></div></form>
</x-guest-layout>
