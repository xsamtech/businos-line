<?php

namespace Tests\Feature\Auth;

use App\Models\PasswordResetToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Storage::fake('public');

        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone' => '+33123456789',
            'address_1' => '1 rue de la Tontine',
            'city' => 'Paris',
            'department' => 'Paris',
            'avatar_base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9ZlWQAAAAASUVORK5CYII=',
            'id_card' => UploadedFile::fake()->image('identity.jpg'),
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('savings', absolute: false));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('files', ['file_type' => 'photo', 'mime_type' => 'image/png']);
        $this->assertDatabaseHas('password_reset_tokens', ['email' => 'test@example.com']);
        $this->assertMatchesRegularExpression('/^\d{6}$/', PasswordResetToken::where('email', 'test@example.com')->firstOrFail()->token);
        $this->assertDatabaseHas('notifications', ['type' => 'welcome_new_member']);
    }
}
