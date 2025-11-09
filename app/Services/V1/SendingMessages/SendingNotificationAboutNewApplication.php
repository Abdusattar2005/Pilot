<?php
namespace App\Services\V1\SendingMessages;

use App\Models\UserNotificationSetting;
use App\Services\V1\SendingMessages\SendEmailService;
use App\Services\V1\SendingMessages\SendingNotificationsTelegramSubscribers;

//отправка уведомлений о новой заявке мастеру и салону
//new \App\Services\V1\SendingMessages\SendingNotificationAboutNewApplication(3, ['привет медведь', 'хай аааа']);
class SendingNotificationAboutNewApplication
{
    private UserNotificationSetting $setting;

    public function __construct(
        private int $user_id,
        private array $messages = [],        
        private string $subject = 'У Вас новая заявка',
        private string $title = 'Bronixs: У Вас новая заявка',        
    ){
        $this->run();
    }
    
    protected function run(){        
        if(!$this->getUserNotificationSettings()) return false;
        $this->sendEmailNotification();
        $this->sendTelegramNotification();
    }

    protected function getUserNotificationSettings():bool{      
        $setting = UserNotificationSetting::where('user_id', $this->user_id)->first();
        if(empty($setting)) return false;
        $this->setting = $setting;
        return true;
    }

    protected function sendEmailNotification(){      
        if($this->setting->enable_email_new_application == 1 && !empty($this->setting->email)){
            new SendEmailService($this->setting->email, $this->messages, $this->subject, $this->title);
        }        
    }

    protected function sendTelegramNotification(){      
        if($this->setting->enable_telegram_new_application == 1){
            $messages = $this->messages;
            array_unshift($messages, $this->subject.':');       
            new SendingNotificationsTelegramSubscribers($this->user_id, $messages);
        }        
    }

}
