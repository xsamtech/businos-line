<section>
    <header><h2 class="text-lg font-medium text-gray-900">{{ __('messages.profile_information') }}</h2><p class="mt-1 text-sm text-gray-600">{{ __('messages.profile_information_help') }}</p></header>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">@csrf @method('patch')
        <div class="flex flex-col items-center gap-3">
            <button id="avatar-picker" class="group relative flex h-[250px] w-[250px] shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-gray-200 shadow-lg ring-2 ring-indigo-100" type="button" aria-label="{{ __('messages.change_avatar') }}">
                @if($user->avatar)
                    <img id="avatar-preview" class="h-full w-full object-cover" src="{{ Storage::url($user->avatar->file_url) }}" alt="{{ $user->name }}"><span id="avatar-placeholder" class="hidden">{{ __('messages.add_photo') }}</span>
                @else
                    <span id="avatar-placeholder" class="text-center text-sm font-medium text-gray-500">{{ __('messages.add_photo') }}</span><img id="avatar-preview" class="hidden h-full w-full object-cover" alt="{{ __('messages.avatar_preview') }}">
                @endif
            </button>
            <p class="text-center text-xs text-gray-500">{{ __('messages.avatar_help') }}</p>
            <input id="avatar-source" class="hidden" type="file" accept="image/jpeg,image/png,image/webp"><input id="avatar-base64" type="hidden" name="avatar_base64"><x-input-error :messages="$errors->get('avatar_base64')" />
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach([['firstname','firstname','text'],['lastname','lastname','text'],['email','email','email'],['phone','phone','tel'],['address_1','address','text'],['address_2','address_2','text'],['country','country','text'],['city','city','text'],['department','department','text']] as [$name,$label,$type])
                <div><x-input-label :for="$name" :value="__('messages.'.$label)"/><x-text-input :id="$name" :name="$name" :type="$type" class="mt-1 block w-full" :value="old($name, $user->{$name})" :required="$name !== 'address_2'"/><x-input-error class="mt-2" :messages="$errors->get($name)"/></div>
            @endforeach
        </div>
        <div class="flex items-center gap-4"><x-primary-button>{{ __('messages.save') }}</x-primary-button>@if(session('status') === 'profile-updated')<p class="text-sm text-green-600">{{ __('messages.saved_message') }}</p>@endif</div>
    </form>
</section>
