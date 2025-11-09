<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {

        //print_r($this->details);exit;
        /*
                [subject] => Подтверждение Email адреса
                [title] => Укажите код чтобы подтвердить Ваш email адрес
                [body] => Код: 72376
        */

        return $this->subject($this->details['subject'] ?? '')//это строка в майле типа что за письмо Восстановление пароля
                    ->markdown('emails.email')//->view('emails.email');
                    ->with([
                                    'subject_1' => $this->details['subject_1' ?? ''],
                                    'subject_2' => $this->details['subject_2' ?? ''],
                                    'title' => $this->details['title'] ?? '',
                                    'code' => $this->details['body'] ?? null,
                    ]);
    }
}
