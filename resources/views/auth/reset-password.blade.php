<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">@csrf
        <div><x-input-label for="token" :value="__('messages.six_digit_code')"/><x-text-input id="token" class="mt-1 block w-full text-center text-2xl tracking-[0.45em]" type="text" inputmode="numeric" maxlength="6" pattern="[0-9]{6}" name="token" :value="old('token', $request->route('token'))" required autofocus/><x-input-error :messages="$errors->get('token')" class="mt-2"/></div>
        <div><x-input-label for="email" :value="__('messages.email')"/><x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email', $request->email)" required/><x-input-error :messages="$errors->get('email')" class="mt-2"/></div>
        <div><x-input-label for="password" :value="__('messages.new_password')"/><x-password-input id="password" class="mt-1 block" name="password" required autocomplete="new-password"/><x-input-error :messages="$errors->get('password')" class="mt-2"/></div>
        <div><x-input-label for="password_confirmation" :value="__('messages.confirm_password')"/><x-password-input id="password_confirmation" class="mt-1 block" name="password_confirmation" required autocomplete="new-password"/><x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/></div>
        <div class="flex justify-end"><x-primary-button>{{ __('messages.reset_password') }}</x-primary-button></div>
    </form>
</x-guest-layout>
