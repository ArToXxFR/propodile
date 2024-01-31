<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class MailJoinRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $team_id;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $team_id)
    {
        $this->user = $user;
        $this->team_id = $team_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "$this->user demande à rejoindre votre projet !",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.team-join-request',
            with: [
                'user' => $this->user,
                'acceptUrl' => URL::signedRoute('team.accept', ['id' => $this->team_id]),
                'profileUrl' => URL::signedRoute('user.show', ['username' => $this->user])
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
