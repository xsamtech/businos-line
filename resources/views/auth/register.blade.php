<x-guest-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">
    @endpush

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-6 flex gap-3 rounded-lg border border-blue-300 bg-blue-50 p-4 text-blue-950 shadow-sm" role="alert">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white" aria-hidden="true">!</span>
            <div class="min-w-0">
                <p class="font-semibold">Information importante</p>
                <p class="mt-1 text-sm leading-6">{{ __('messages.paypal_email_notice') }}</p>
            </div>
        </div>

        <div class="flex flex-col items-center gap-3 pb-6">
            <button id="avatar-picker" class="group relative flex h-[250px] w-[250px] shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-gray-200 shadow-lg ring-2 ring-indigo-100" type="button" aria-label="Choisir et recadrer une photo de profil">
                <span id="avatar-placeholder" class="text-center text-sm font-medium text-gray-500 group-hover:text-indigo-600">Ajouter<br>une photo</span>
                <img id="avatar-preview" class="hidden h-full w-full object-cover" alt="Aperçu de la photo de profil">
            </button>
            <p class="text-center text-xs text-gray-500">Cliquez sur l’avatar pour choisir et recadrer votre photo.</p>
            <input id="avatar-source" class="hidden" type="file" accept="image/jpeg,image/png,image/webp">
            <input id="avatar-base64" type="hidden" name="avatar_base64" value="{{ old('avatar_base64') }}">
            <x-input-error :messages="$errors->get('avatar_base64')" />
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach([['firstname', 'Prénom', 'text'], ['lastname', 'Nom', 'text'], ['email', 'Email PayPal', 'email'], ['phone', 'Téléphone', 'tel'], ['address_1', 'Adresse', 'text'], ['city', 'Ville', 'text'], ['department', 'Département', 'text']] as [$name, $label, $type])
                <div><x-input-label :for="$name" :value="$label"/><x-text-input :id="$name" class="mt-1 block w-full" :type="$type" :name="$name" :value="old($name)" required/><x-input-error :messages="$errors->get($name)" class="mt-2"/></div>
            @endforeach
            <div><x-input-label for="id_card" value="Carte d’identité"/><input id="id_card" class="mt-1 block w-full" type="file" name="id_card" accept="image/*,.pdf" required><x-input-error :messages="$errors->get('id_card')"/></div>
            <div><x-input-label for="password" value="Mot de passe"/><x-password-input id="password" class="mt-1 block" name="password" required autocomplete="new-password"/><x-input-error :messages="$errors->get('password')"/></div>
            <div><x-input-label for="password_confirmation" value="Confirmer le mot de passe"/><x-password-input id="password_confirmation" class="mt-1 block" name="password_confirmation" required autocomplete="new-password"/></div>
        </div>
        <div class="mt-4 flex items-center justify-end gap-4"><a class="text-sm underline" href="{{ route('login') }}">Déjà inscrit ?</a><x-primary-button>S’inscrire</x-primary-button></div>
    </form>

    <dialog id="avatar-dialog" class="max-h-[90vh] w-[min(92vw,42rem)] overflow-hidden rounded-xl bg-white p-0 shadow-2xl backdrop:bg-gray-950/70">
        <div class="flex max-h-[90vh] min-h-0 flex-col">
            <div class="flex shrink-0 items-center justify-between gap-4 border-b border-gray-200 px-5 py-4"><h2 class="text-lg font-semibold text-gray-900">Recadrer la photo</h2><button id="avatar-cancel" type="button" class="rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">Annuler</button></div>
            <div class="min-h-[18rem] flex-1 overflow-hidden bg-gray-950"><img id="avatar-crop-image" class="block max-h-[60vh] max-w-full" alt="Image à recadrer"></div>
            <div class="relative z-10 flex shrink-0 justify-end border-t border-gray-200 bg-white px-5 py-4 shadow-[0_-4px_12px_rgba(0,0,0,0.08)]"><button id="avatar-apply" type="button" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Enregistrer l’image recadrée</button></div>
        </div>
    </dialog>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
        <script src="{{ asset('assets/js/register-avatar.js') }}"></script>
    @endpush
</x-guest-layout>
