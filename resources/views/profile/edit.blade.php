<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <dialog id="avatar-dialog" class="max-h-[90vh] w-[min(92vw,42rem)] overflow-hidden rounded-xl bg-white p-0 shadow-2xl backdrop:bg-gray-950/70">
        <div class="flex max-h-[90vh] min-h-0 flex-col"><div class="flex shrink-0 items-center justify-between gap-4 border-b border-gray-200 px-5 py-4"><h2 class="text-lg font-semibold">{{ __('messages.crop_avatar') }}</h2><button id="avatar-cancel" type="button" class="rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">{{ __('messages.cancel') }}</button></div><div class="min-h-[18rem] flex-1 overflow-hidden bg-gray-950"><img id="avatar-crop-image" class="block max-h-[60vh] max-w-full" alt="{{ __('messages.crop_avatar') }}"></div><div class="relative z-10 flex shrink-0 justify-end border-t border-gray-200 bg-white px-5 py-4"><button id="avatar-apply" type="button" class="rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white">{{ __('messages.save_cropped_image') }}</button></div></div>
    </dialog>
    @push('styles')<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">@endpush
    @push('scripts')<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script><script src="{{ asset('assets/js/register-avatar.js') }}"></script>@endpush
</x-app-layout>
