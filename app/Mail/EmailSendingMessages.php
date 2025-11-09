<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSendingMessages extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject($this->details['subject'] ?? '')//это строка в майле типа что за письмо Восстановление пароля
                    ->markdown('emails.email_sending_messages')//->view('emails.email');
                    ->with([
                                    'title' => $this->details['title'] ?? '',
                                    'messages' => $this->details['messages'] ?? [],
                    ]);
    }
}
