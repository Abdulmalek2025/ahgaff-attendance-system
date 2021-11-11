<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeanExcuseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $sender;
    private $path;
    private $date;
    private $title;
    public function __construct($sender, $title, $path, $date)
    {
        $this->sender = $sender;
        $this->title = $title;
        $this->path = $path;
        $this->date = $date;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase(){
        return [
            'sender'=> $this->sender,
            'title' => $this->title,
            'path'=> $this->path,
            'date'=> $this->date
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
