<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendInfo extends Notification
{
    use Queueable;
    protected $parentName;
    protected $childName;
    protected $day;
    protected $time;
    protected $group;
    protected $status;

    public function __construct($parentName, $childName, $day, $time, $group, $status)
    {
        $this->parentName = $parentName;
        $this->childName = $childName;
        $this->day = $day;
        $this->time = $time;
        $this->group = $group;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
    
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Уведомление для ' . $this->parentName);

        if ($this->status == 0) {
            $mail->line($this->childName . ' зарегистрировали')
                ->line('Он ходит в ' . $this->group . ' в ' . $this->time . ', ' . $this->day);
        } elseif ($this->status == 1) {
            $mail->line($this->childName)
                ->line('Он ходил в ' . $this->group . ' в ' . $this->time . ', ' . $this->day . ' и его скоро переведут в другую');
        } elseif ($this->status == 2) {
            $mail->line($this->childName)
                ->line('Его записали в ' . $this->group . ' в ' . $this->time . ', ' . $this->day);
        }

        $mail->line('Если есть ошибки или вы по ошибке получили это сообщение, обратитесь с проблемой на нашу почту support@itfrog.com с этим письмом');

        return $mail;
    }
}