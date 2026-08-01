<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AvatarStorage
{
    public function store(User $user, string $dataUrl, bool $replaceExisting = false): File
    {
        [$metadata, $encodedImage] = explode(',', $dataUrl, 2);
        $image = base64_decode($encodedImage, true);
        $imageInfo = $image === false ? false : getimagesizefromstring($image);
        $allowedMimeTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if ($image === false || $imageInfo === false || ! isset($allowedMimeTypes[$imageInfo['mime']]) || mb_strlen($image, '8bit') > 2 * 1024 * 1024) {
            throw ValidationException::withMessages(['avatar_base64' => __('messages.invalid_avatar')]);
        }
        if (! str_contains($metadata, $imageInfo['mime'])) {
            throw ValidationException::withMessages(['avatar_base64' => __('messages.invalid_avatar_type')]);
        }
        $formerAvatar = $replaceExisting ? $user->avatar()->first() : null;
        $fileName = Str::uuid().'.'.$allowedMimeTypes[$imageInfo['mime']];
        $path = 'members/'.$user->uuid.'/'.$fileName;
        Storage::disk('public')->put($path, $image);
        $avatar = File::create(['file_name' => $fileName, 'file_url' => $path, 'file_type' => 'photo', 'mime_type' => $imageInfo['mime'], 'file_size' => mb_strlen($image, '8bit'), 'user_id' => $user->id]);
        if ($formerAvatar) {
            Storage::disk('public')->delete($formerAvatar->file_url);
            $formerAvatar->delete();
        }

        return $avatar;
    }
}
