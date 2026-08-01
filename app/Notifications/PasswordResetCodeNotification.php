<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetCodeNotification extends Notification
{
    use Queueable;

    public function __construct(public string $code) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject(__('messages.reset_code_subject'))->greeting(__('messages.hello_name', ['name' => $notifiable->firstname]))->line(__('messages.reset_code_intro'))->line(__('messages.reset_code_value', ['code' => $this->code]))->action(__('messages.reset_password'), route('password.reset', ['token' => $this->code, 'email' => $notifiable->email]))->line(__('messages.reset_code_expiry'));
    }
}
