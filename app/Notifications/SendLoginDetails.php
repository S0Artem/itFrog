<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLoginDetails extends Notification
{
    use Queueable;

    protected $user;
    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
    
    public function toMail($notifiable)
    {
        #//TODO:Разобраться как это работает до конца
        return (new MailMessage)
            ->subject('Здраствуйте  ' . $this->user->name . '. Ваши данные для входа')
            ->line('Здраствуйте  ' . $this->user->name . '. Ваши данные для входа')
            ->line('Ваш логин: ' . $this->user->email)
            ->line('Ваш пароль: ' . $this->password)
            ->line('Спасибо за использование нашего сервиса!');
    }
}