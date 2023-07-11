<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamPlayerInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $playerEmail)
    {
        $this->email = $playerEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)
                ->subject(env('APP_NAME') . ' - Você foi convidado por um time!')
                ->view('mail.player_invited');
    }
}
