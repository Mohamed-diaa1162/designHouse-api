<?php

namespace App\Notifications;



use Illuminate\Auth\Notifications\VerifyEmail as Notification ;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;



class VerifyEmail extends Notification
{
    use Queueable;

    protected function verificationUrl($notifiable)
    {
        $appURL = config('app.client_url' , config('app.url')) ;

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['user' => $notifiable->id]
        );
        return str_replace(url('/api/guest'), $appURL , $url ) ;
    }

}