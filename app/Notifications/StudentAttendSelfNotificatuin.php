<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentAttendSelfNotificatuin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $course;
    public $teacher;
    public $student_id;
    public $date;
    public $lecture_id;
    public function __construct($lecture_id, $teacher, $student_id, $date, $course)
    {
        $this->course = $course;
        $this->teacher = $teacher;
        $this->student_id = $student_id;
        $this->date = $date;
        $this->period = $lecture_id;

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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase(){
        return [
            'lecture_id'=> $this->lecture_id,
            'student_id' => $this->student_id,
            'teacher'=> $this->teacher,
            'date'=> $this->date,
            'course'=> $this->course,
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
            'lecture_id'=> $this->lecture_id,
            'student_id' => $this->student_id,
            'teacher'=> $this->teacher,
            'date'=> $this->date,
            'course'=> $this->course,
        ];
    }
}
