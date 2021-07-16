<?php

namespace App\Notifications;


use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

class passwordReset extends Notification
{
    public function toMail($notifiable)
    {
        $url = url(config('app.client_url').'/password/reset/' . $this->token).
        '?email='. urlencode($notifiable->email);
        return (new MailMessage)
                    ->line('You are receiving this email because we received a password rest request for your account')
                    ->action('Rest Password', $url )
                    ->line('if you dont won\'t to rest no action is required ');
    }
    
}