<?php
namespace App\Traits;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

trait TraitSsendingEmail
{
    public function SendVerificationEmail(string $email, int $code):void
    {
        //$url = 'Code: '.$code;        
        Mail::to($email)->send(new SendEmail([
            'subject' => trans('messages.1009'),
            'title' => trans('messages.1013'),
            'subject_1' => trans('messages.1014'),
            'subject_2' => trans('messages.1015'),                  
            'body' => $code,
        ]));
    }

    public function SendCodeInEmail(string $email, int $code):void
    {
        Mail::to($email)->send(new SendEmail([
            'subject' => trans('messages.1021'),
            'title' => trans('messages.1013'),
            'subject_1' => trans('messages.1022'),
            'subject_2' => trans('messages.1015'),                  
            'body' => $code,
        ]));
    }

}

