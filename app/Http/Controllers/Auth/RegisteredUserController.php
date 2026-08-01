<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Services\AvatarStorage;
use App\Services\PasswordResetCodeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(private AvatarStorage $avatarStorage, private PasswordResetCodeService $resetCodes) {}

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['firstname' => ['required', 'string', 'max:255'], 'lastname' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255', 'unique:users'], 'phone' => ['required', 'string', 'max:20', 'unique:users'], 'address_1' => ['required', 'string', 'max:2000'], 'city' => ['required', 'string', 'max:255'], 'department' => ['required', 'string', 'max:255'], 'avatar_base64' => ['nullable', 'string', 'max:3000000', 'regex:/^data:image\/(jpeg|png|webp);base64,/'], 'id_card' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'mimetypes:image/jpeg,image/png,application/pdf', 'max:5120'], 'password' => ['required', 'confirmed', Rules\Password::defaults()]]);
        $user = User::create(['firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'email' => $data['email'], 'phone' => $data['phone'], 'address_1' => $data['address_1'], 'city' => $data['city'], 'department' => $data['department'], 'password' => Hash::make($data['password'])]);
        $member = Role::where('slug', 'member')->first();
        if ($member) {
            $user->roles()->attach($member, ['is_default' => true, 'assigned_at' => now()]);
        }
        if (! empty($data['avatar_base64'])) {
            $this->avatarStorage->store($user, $data['avatar_base64']);
        }
        foreach (['id_card' => 'id_card'] as $input => $type) {
            if ($request->hasFile($input)) {
                $uploaded = $request->file($input);
                $path = $uploaded->store('members/'.$user->uuid, 'public');
                File::create(['file_name' => $uploaded->hashName(), 'file_url' => $path, 'file_type' => $type, 'mime_type' => $uploaded->getMimeType(), 'file_size' => $uploaded->getSize(), 'user_id' => $user->id]);
            }
        }
        $this->resetCodes->generate($user);
        AppNotification::create(['type' => 'welcome_new_member', 'to_user_id' => $user->id]);
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('savings');
    }
}
