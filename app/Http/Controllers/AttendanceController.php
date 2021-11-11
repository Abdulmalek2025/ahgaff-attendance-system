<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Group;
use App\Sem_co;
use Auth;
use App\Lecture;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function update(Request $request)
    {
        $attendance = Attendance::where('lec_id', $request->course)->get();
        for ($i = 0; $i < count($attendance); $i++) {
            for ($j = 0; $j < count($request->status); $j++) {
                if ($request->status[$j] == $attendance[$i]->student_id) {
                    $attendance[$i]->is_present = 1;
                    $attendance[$i]->update();
                }
            }
        }
        return response()->json(array('good' => $attendance));
    }
    public function filter(Request $request)
    {   $sem_co = Sem_co::where('id',$request->id)->with('group')->first();
        $lectures = Lecture::where('sem_co_id',$request->id)->get();
    return response()->json(array('lectures'=>$lectures,'sem_co'=>$sem_co));
    }
    public function setSemesterCourse()
    {
        $groups_id = [];$i = 0;
        $groups = Group::where('collage_id',auth::user()->collage_id)->with('user')->get();
        foreach($groups as $group){
            $groups_id[$i] = $group->id;
            $i++;
        }
        $sem_cos = Sem_co::whereIn('group_id',$groups_id)->with('course', 'group', 'teacher', 'semester', 'lectures')->get();
        return response()->json(['sem'=>$sem_cos,'group'=>$groups]);
        /*$sem = Sem_co::orderBy('id', 'ASC')->with('course', 'group', 'teacher', 'semester', 'lectures')->get();
        $data = Sem_co::orderBy('id', 'ASC')->with('group', 'lectures', 'teacher', 'group', 'course')->first();
        $attendance = [];
        $group = [];
        if (!is_null($data->lectures()->first())) {
            $attendance = Attendance::where('lec_id', $data->lectures()->first()->id)->get();
            $group = Group::where('id', $data->group()->first()->id)->with('user')->first();
        }
        return response()->json(array('sem' => $sem, 'group' => $group, 'attendance' => $attendance));*/

    }
    public function filterLecture(Request $request)
    {
        $attendance = Attendance::where('lec_id', $request->id)->with('student')->get();
        return response()->json(array('attendance' => $attendance));
    }
    public function student_update(Request $request)
    { //teacher_student_attendance,student-id-attendance,course_student_attendance,open_time_student_attendance,period_student_attendance

    }
}
