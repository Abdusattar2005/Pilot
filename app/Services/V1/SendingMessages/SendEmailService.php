<?php
namespace App\Services\V1\SendingMessages;

use App\Mail\EmailSendingMessages;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    public function __construct(
        private string $email,
        private array $messages,
        private string $subject = 'Письмо от Bronixs',
        private string $title = 'Вам поступило письмо от Bronixs',        
    ){
        $this->run();
    }
    
    public function run(){        
        Mail::to($this->email)->send(new EmailSendingMessages([
            'subject' => $this->subject,   
            'title' => $this->title,   
            'messages' => $this->messages,            
            ]));
    }

}
