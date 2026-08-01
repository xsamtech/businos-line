@props(['disabled' => false])

<div x-data="{ visible: false }" class="relative">
    <input x-bind:type="visible ? 'text' : 'password'" @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-md border-gray-300 pr-11 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}>
    <button type="button" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-md text-gray-500 transition hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" x-on:click="visible = ! visible" x-bind:aria-label="visible ? @js(__('messages.hide_password')) : @js(__('messages.show_password'))" x-bind:title="visible ? @js(__('messages.hide_password')) : @js(__('messages.show_password'))">
        <svg x-show="! visible" aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><circle cx="12" cy="12" r="3"/></svg>
        <svg x-cloak x-show="visible" aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 10.7a2 2 0 0 0 2.7 2.7M9.9 4.4A10.8 10.8 0 0 1 12 4.2c6 0 9.75 7.8 9.75 7.8a18 18 0 0 1-2.2 3.3M6.2 6.2C3.6 8.1 2.25 12 2.25 12S6 19.8 12 19.8a9.7 9.7 0 0 0 3.2-.55"/></svg>
    </button>
</div>
