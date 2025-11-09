<?php
namespace App\Services\V1\SendingMessages;

use App\Models\SubscribersMailingTelegram;

//отправка уведомлений о новой заявке телеграм подписчикам
class SendingNotificationsTelegramSubscribers
{
    private object|null $users_telegram = null;
    private string $mess = '';    
    
    public function __construct(
        private int $user_id,
        private array $messages      
    ){
        $this->run();
    }
    
    protected function run(){
        if(count($this->messages) == 0) return false;
        if(!$this->getUsersTelegram()) return false;
        $this->convertMessages();
        $this->send();
       
    }

    protected function getUsersTelegram():bool{      
        $users_telegram = SubscribersMailingTelegram::where('user_id', $this->user_id)->get();
        if(empty($users_telegram)) return false;
        if(count($users_telegram) == 0) return false;        
        $this->users_telegram = $users_telegram;
        return true;
    }

    //массив преобразуем в строку, + сделаем так чтобы каждое значение массива в телеграме была с новой строки
    protected function convertMessages():void{   ////%0A   
        foreach ($this->messages as $key => $value){
            $this->messages[$key] = '%0A'.$value;
        }

        $this->mess = implode(" ", $this->messages);    
    }

    protected function send():void{        
        foreach ($this->users_telegram as $key => $value) {
            if(!empty($value->telegram_id_subscriber) && is_numeric(($value->telegram_id_subscriber))){               
                file_get_contents('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TWO_ID', null).'/sendMessage?chat_id='.$value->telegram_id_subscriber.'&text='.$this->mess.''); 
            }
        }
        
    }

}
