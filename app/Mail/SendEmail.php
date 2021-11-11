<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $student;
    public $subject;
    public $body;
    public $report;
    public function __construct($student,$subject, $body, $report)
    {
        $this->student = $student;
        $this->subject = $subject;
        $this->body = $body;
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   $data['name'] = $this->student;
        $data['subject'] = $this->subject;
        $data['body'] = $this->body;
        $data['report'] = $this->report;
        return $this->from('attendance.system.universty2021@gmail.com')->view('admins.mail-templete')->with($data);
    }
}
