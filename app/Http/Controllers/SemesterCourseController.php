<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Group;
use App\Lecture;
use App\Sem_co;
use App\Teacher;
use App\Student;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SemesterCourseController extends Controller
{
    public function index()
    {   $groups_id = [];$i = 0;
        $groups = Group::where('collage_id',auth::user()->collage_id)->get();
        foreach ($groups as $group) {
            $groups_id[$i] = $group->id;
            $i++;
        }
        $data['rows'] = Sem_co::orderBy('id', 'DESC')->whereIn('group_id',$groups_id)->with('group', 'teacher', 'course', 'semester')->get();
        return view('admins/semester_course')->with($data);
    }
    public function openAddModal()
    {
        $groups = Group::orderBy('name', 'DESC')->where('collage_id',auth::user()->collage_id)->with('user')->get();
        $courses = Course::orderBy('name', 'DESC')->where('collage_id',auth::user()->collage_id)->get();
        $users = User::where('userable_type','App\Teacher')->where('collage_id',auth::user()->collage_id)->get();
        $teachers_id = [];$i = 0;
        foreach ($users as $user) {
            $teachers_id[$i] = $user->userable_id;
            $i++;
        }
        $teachers = Teacher::orderBy('name', 'DESC')->whereIn('id',$teachers_id)->get();
        return response()->json(array('groups' => $groups, 'courses' => $courses, 'teachers' => $teachers));
    }
    public function store(Request $request)
    {
        $studentId = DB::table('student_groups')->where('group_id', $request->group)->first()->student_id;
        $semesterId = Student::where('student_id', $studentId)->first()->semester_id;
        if ($request->ajax()) {
            $request->validate([
                'group' => 'required|string|max:50',
                'course' => 'required|string|max:50',
                'teacher' => 'required|string|max:50',
            ]);

            // dd($request->name);
            $sem = Group::findOrFail($request->group)->with('user')->first();
            $data = new Sem_co;
            $data->group_id = $request->group;
            $data->course_id = $request->course;
            $data->teacher_id = $request->teacher;
            $data->semester_id = $semesterId;
            $data->save();
            $respond['row'] = $data;
            return view('semester_course/row')->with($respond);
        }
    }
    public function delete($id)
    { //$sem_co_id = Sem_co::find($id)->id;
        $ids = [];
        $counter = 0;
        $lecs = Lecture::where('sem_co_id', $id)->get();
        foreach ($lecs as $lec) {
            $ids[$counter] = $lec->id;
            $counter++;
        }
        Attendance::whereIn('lec_id', $ids)->delete();
        Lecture::where('sem_co_id', $id)->delete();
        Sem_co::findOrfail($id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }
    public function edit($id)
    {
        $data = Sem_co::findOrfail($id);
        $groups = Group::orderBy('name', 'DESC')->get();
        $courses = Course::orderBy('name', 'DESC')->get();
        $teachers = Teacher::orderBy('name', 'DESC')->get();
        return response()->json(array('data' => $data, 'groups' => $groups, 'courses' => $courses, 'teachers' => $teachers));
    }
    public function update(Request $request)
    {$studentId = DB::table('student_groups')->where('group_id', $request->group)->first()->student_id;
        $semesterId = Student::where('student_id', $studentId)->first()->semester_id;
        if ($request->ajax()) {
            $request->validate([
                'group' => 'required|string|max:50',
                'course' => 'required|string|max:50',
                'teacher' => 'required|string|max:50',
            ]);
            // dd($request->name);
            $sem = Group::where('id', $request->group)->with('user')->first();
            $data = Sem_co::findOrFail($request->id);
            $data->group_id = $request->group;
            $data->course_id = $request->course;
            $data->teacher_id = $request->teacher;
            $data->semester_id = $semesterId;
            $data->save();
            $respond['row'] = $data;
            return view('semester_course/rowEdit')->with($respond);
        }
    }
}
