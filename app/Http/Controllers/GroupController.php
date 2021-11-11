<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Group;
use App\Student;
use App\StudentGroup;
use Auth;
use App\Semester;
use App\Major;
use App\Sem_co;
use App\Lecture;
use App\Attendance;
class GroupController extends Controller
{
    public function index()
    {
        $data['rows'] = Group::orderBy('id','DESC')->where('collage_id',auth::user()->collage_id)->get();
        $data['semesters'] = Semester::orderBy('id','ASC')->get();
        $data['majors'] = Major::where('collage_id',auth::user()->collage_id)->get();
        return view('admins/groups')->with($data);
    }
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $request->validate([
                'name' =>'required|string|max:50',
                'start_date' =>'required|date|before:end_date',
                'end_date' =>'required|date|after:start_date',
            ]);
            $user = auth::user();
            $data = new Group;
            $data->name = $request->name;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->collage_id = $user->collage_id;
            $data->save();
            $respond['row'] = $data;
            return view('groups/row')->with($respond);
        }
    }
    public function delete($id)
    {   $sem_cos = Sem_co::where('group_id',$id)->get();
        $sem_co_ids = [];$counter = 0;
        foreach ($sem_cos as $key => $sem_co) {
            $sem_co_ids[$counter] = $sem_co->id;
            $counter++;
        }
        $lectures = Lecture::whereIn('sem_co_id',$sem_co_ids)->get();
        foreach ($lectures as $lecture) {
            Attendance::where('lec_id',$lecture->id)->delete();
        }
        Lecture::whereIn('sem_co_id',$sem_co_ids)->delete();
        Sem_co::where('group_id',$id)->delete();
        DB::table('student_groups')->where('group_id',$id)->delete();
        Group::findOrfail($id)->delete();
        return response()->json(['success'=>'Deleted Success','id'=>$id]);
    }
    public function edit($id)
    {
        $data = Group::findOrfail($id);
        return response()->json(array('data'=>$data));
    }
    public function update(Request $request)
    {
        if($request->ajax())
        {
            $request->validate([
                'edit_name' =>'required|string|max:50',
                'edit_start_date' =>'required|date|before:edit_end_date',
                'edit_end_date' =>'required|date|after:edit_start_date',
            ]);
            // dd($request->name);
            $user = auth::user();
            $data = Group::findOrFail($request->edit_id);
            $data->name = $request->edit_name;
            $data->start_date = $request->edit_start_date;
            $data->end_date = $request->edit_end_date;
            $data->collage_id = $user->collage_id;
            $data->save();
            $respond['row'] = $data;
            return view('groups/rowEdit')->with($respond);
        }
    }
    /**student edit */
    public function editStudent($id)
    {   $students_id = [];  $counter = 0;
        $data = Group::findOrFail($id);
        $students = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Student')->get();
        foreach ($students as $student) {
            $students_id[$counter] = $student->userable_id;
            $counter++;
        }

        $state = Group::where('id',$id)->with('user')->get();
        $major = Major::where('collage_id',auth::user()->collage_id)->first()->id;
        $student = Student::where('semester_id',1)->where('major_id',$major)->whereIn('id',$students_id)->with('addresses')->get();
        return response()->json(array('data'=>$data,'student'=>$student,'state'=>$state));
    }
    public function updateStudent(Request $request)
    {   //$id = Group::findOrfail((int)$request->id);
        //dd($id->id);
        StudentGroup::where('group_id',$request->add_student_id)->delete();
        if(!is_null($request->status)){
            for($i = 0;$i <  count($request->status);$i++){
                StudentGroup::create(['group_id'=>$request->add_student_id,'student_id'=>$request->status[$i]]);
                }
            if($request->ajax())
            {
                $request->validate([
                    'add_student_name' =>'string|max:50',
                    'add_student_start_date' =>'date|before:add_student_end_date',
                    'add_student_end_date' =>'date|after:add_student_start_date',
                ]);
                $data = $request->status;
                return response()->json(array('data'=>$data));
            }
        }

    }
    public function filter(Request $request)
    {   //semester_id, major_id, group_id
        $students = [];$counter = 0;
        $students = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Student')->get();
        foreach ($students as $student) {
            $students_id[$counter] = $student->userable_id;
            $counter++;
        }
        $data = Group::where('id',(int)$request->group)->with('user')->first();
        $student = Student::where('semester_id',$request->semester_id)->where('major_id',$request->major_id)->whereIn('id',$students_id)->with('addresses')->get();

        return response()->json(array('data'=>$data,'student'=>$student));
        //$data['rows'] = Student::where('student_id',$request->id)->get();
    }
}
