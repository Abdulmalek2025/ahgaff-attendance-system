<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentAttendSelf implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
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
        $this->lecture_id = $lecture_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('StudentAttendSelf');
    }
}
