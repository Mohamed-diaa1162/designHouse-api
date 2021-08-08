<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvitationToJoinTeam extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $Invitation;
    public $user_exsits;

    public function __construct(Invitation $invitation, $user_exsits)
    {
        $this->invitation = $invitation;
        $this->user_exsits = $user_exsits;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->user_exsits) {
            $url = config('app.client.url') . '/setting/teams' . $this->invitation->recipient_email;
            return $this->markdown('emails.invitations.invite-new-user')
                ->subject("invation to join Team" . $this->invitation->team->name)
                ->with([
                    'invitation' => $this->invitation,
                    'url' => $url,
                    'Register' => true
                ]);
        } else {
            $url = config('app.client.url') . '/Register?invitation=' . $this->invitation->recipient_email;
            return $this->markdown('emails.invitations.invite-new-user')
                ->subject("invation to join Team" . $this->invitation->team->name)
                ->with([
                    'invitation' => $this->invitation,
                    'url' => $url,
                    'Register' => false,
                ]);
        }
    }
}