<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Collage;
use App\Events\SendMessage;
use App\Excuse;
use App\Ill_Excuse;
use App\Lecture;
use App\Major;
use App\Mobile;
use App\Semester;
use App\Sem_co;
use App\Student;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $data['rows'] = Student::orderBy('id', 'DESC')->get();
        $data['majors'] = Major::where('collage_id',auth::user()->collage_id)->get();
        return view('admins/students')->with($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'student_id' => 'required|string|max:10|unique:students',
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\'\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'phone' => 'required|string|max:10',
                'major' => 'required|string',
                'semesters' => 'required|string',
                'email' => 'required|email|string|unique:users',
            ]);

            $t = User::findOrFail(auth::id());
            $data = new Student;
            $data->id = $request->student_id;
            $data->student_id = $request->student_id;
            $data->name = $request->name;
            $data->major_id = $request->major;
            $data->semester_id = $request->semesters;
            $data->save();
            $data->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->create(['mobile' => $request->mobile]);
            $data->mobiles()->create(['mobile' => $request->phone]);
            $data->user()->create(['email' => $request->email, 'password' => Hash::make('12345678'), 'type' => 'Student', 'collage_id' => $t->collage_id]);
            $respond['major'] = Major::where('id',$request->major)->first()->name;
            $respond['row'] = $data;
            return view('students/row')->with($respond);
        }
    }

    public function delete($id)
    { //user, notifications,groups,student_groups,ill_excuse,excuse,attendance
        $u = User::where('userable_id', $id)->where('userable_type', 'App\Student')->first();
        if (DB::table('notifications')->where('notifiable_id', $u->id)->count() > 0) {
            $u->notifications()->delete();
        }
        Student::findOrFail($id)->user()->delete();
        DB::table('student_groups')->where('student_id', $id)->delete();
        Mobile::where('mobileable_id', $id)->where('mobileable_type', 'App\Student')->delete();
        Attendance::where('student_id', $id)->delete();
        Student::findOrFail($id)->addresses()->delete();
        Student::findOrFail($id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }

    public function edit($id)
    {
        $data = Student::findOrfail($id);
        $user = $data->user()->first();
        $majors = Major::where('collage_id', auth::user()->collage_id)->get();
        $semesters = Semester::orderBy('id', 'DESC')->get();
        $major = Major::where('id', $data->major()->first()->id)->first()->name;
        $semester = Semester::where('id', $data->semester()->first()->id)->first()->name;
        $address = $data->addresses()->first();
        $mobile = $data->mobiles()->get()->where('mobileable_id', $id)->where('mobileable_type', 'App\Student');
        return response()->json(array('data' => $data, 'address' => $address, 'mobile' => $mobile, 'user' => $user, 'major' => $major, 'semester' => $semester, 'majors' => $majors, 'semesters' => $semesters));
    }
    public function search(Request $request)
    {   $students = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Student')->get();
        $students_id = [];$i = 0;
        foreach($students as $student){
            $students_id[$i] = $student->userable_id;
            $i++;
        }
        $search_result = Student::where('name', 'like', '%' . $request->search . '%')->whereIn('id',$students_id)->with('addresses', 'mobiles')->get();
        $table = '';
        foreach ($search_result as $row) {
            $table .= '<tr id="' . $row->id . '">
            <td class="pl-2">' . $row->id . '</td>
            <td style="min-width:350px;">' . $row->name . '</td>
            <td>' . $row->addresses()->first()->city . '</td>
            <td>' . $row->mobiles()->first()->mobile . '</td>

            <td>
                <a href="#" class="edit-student" data-toggle="modal" data-route="/students/edit/' . $row->id . '"
                    data-target="#edit-student-modal"><i class="bx bx-edit edit-color"></i></a>
                <a href="#" class="delete-student" data-toggle="modal"
                    data-route="/students/delete/' . $row->id . '"><i class="bx bxs-trash delete-color"></i></a>
            </td>
        </tr>';
        }
        return $data = array('row' => $table);
    }

    public function update(Request $request)
    {  
        if ($request->ajax()) {
            $request->validate([
                'student_id' => 'required|string|max:10',
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'phone' => 'required|string|max:10',
                'major' => 'required|string',
                'semesters' => 'required',
            ]);

            $data = Student::findOrFail($request->id);
            $data->student_id = $request->student_id;
            $data->id = $request->student_id;
            $data->name = $request->name;
            $data->major_id = $request->major;
            $data->semester_id = $request->semesters;
            $data->save();
            $data->addresses()->first()->where('addressable_id', $request->id)->where('addressable_type', 'App\Student')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            if (!is_null($data->mobiles()->get()->last())) {
                $data->mobiles()->create(['mobile' => $request->phone]);
            } else {
                $data->mobiles()->get()->last()->update(['mobile' => $request->phone]);
            }
            $respond['major'] = Major::where('id',$request->major)->first()->name;
            $respond['row'] = $data;
            return view('students/rowEdit')->with($respond);
        }
    }
    public function dashboard()
    {
        return view('student/dashboard');
    }
    public function student_setup()
    { //dash board
        $t = auth::user();
        $mine = Student::findOrFail($t->userable_id);
        $groups = DB::table('student_groups')->where('student_id',auth::user()->userable_id)->get();
        $groups_id = [];
        $i = 0;
        foreach ($groups as $group) {
            $groups_id[$i] = $group->group_id;
            $i++;
        }
        $courses = Sem_co::select('course_id')->whereIn('group_id', $groups_id)->distinct()->get();
        $teachers = Sem_co::select('teacher_id')->whereIn('group_id', $groups_id)->distinct()->get();
        $data = Sem_co::whereIn('group_id', $groups_id)->with('course', 'group', 'teacher', 'lectures')->get();
        return response()->json(array('rows' => $data, 'groups' => $groups, 'courses' => count($courses), 'teachers' => count($teachers)));
    }
    public function reports()
    {
        return view('student/reports');
    }
    public function student_report_setup()
    {
        $user = auth::user();
        $i = 0;
        $ids = [];
        $groups_id = DB::table('student_groups')->select('group_id')->where('student_id', auth::user()->userable_id)->get();
        foreach ($groups_id as $id) {
            $ids[$i] = $id->group_id;
            $i++;
        }
        $sem_cos = Sem_co::whereIn('group_id', $ids)->with('course', 'teacher', 'group', 'lectures')->get();
        return response()->json(['sem_cos' => $sem_cos]);
    }
    public function change_courses(Request $request)
    {
        $user = auth::user();
        $lecs_id = Lecture::where('sem_co_id', $request->id)->get();
        $counter = 0;
        $period = 0;
        $ids = [];
        $total_period = 0;
        foreach ($lecs_id as $lec_id) {
            $ids[$counter] = $lec_id->id;
            $counter++;
        }$period = Lecture::select('period')->whereIn('id',$ids)->sum('period');
        if($period == 0){
            $period = 1;
        }
        $result = Attendance::where('student_id',$user->userable_id)->whereIn('lec_id',$ids)->get();
        $lec_num = Attendance::whereIn('lec_id',$ids)->where('student_id',auth::user()->userable_id)->count();
        $ab_attendance = Attendance::where('student_id', auth::user()->userable_id)->where('is_present', 0)->where('attendanceable_type', 'none')->whereIn('lec_id', $ids)->with('lecture')->get();
        $ex_attendance = Attendance::where('student_id', auth::user()->userable_id)->where('is_present', 0)->whereIn('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->whereIn('lec_id', $ids)->with('lecture')->get();
        $pr_attendance = Attendance::where('student_id', auth::user()->userable_id)->where('is_present', 1)->whereIn('lec_id', $ids)->with('lecture')->get();
        $ab_period = 0;
        $ex_period = 0;
        $pr_period = 0;
        if (count($ab_attendance) > 0) {
            foreach ($ab_attendance as $ab_at) {
                $ab_period += $ab_at->lecture()->first()->period;
            }
        }
        if (count($ex_attendance) > 0) {
            foreach ($ex_attendance as $ex_at) {
                $ex_period += $ex_at->lecture()->first()->period;
            }
        }
        if (count($pr_attendance) > 0) {
            foreach ($pr_attendance as $pr_at) {
                $pr_period += $pr_at->lecture()->first()->period;
            }
        }

        if ((($ex_period / $period) * 100 + ($ab_period / $period) * 100) <= 20 || ($ab_period / $period) * 100 <= 10) {
            $status = "Success";
        } elseif (((($ex_period / $period) * 100 + ($ab_period / $period) * 100) > 20 && (($ex_period / $period) * 100 + ($ab_period / $period) * 100) < 70) || ($ab_period / $period) * 100 > 10 && ($ab_period / $period) * 100 <= 70) {
            $status = "Forbidden";
        } elseif ((($ex_period / $period) * 100 + ($ab_period / $period) * 100) >= 70 || (($ab_period / $period) * 100) >= 70) {
            $status = "Dismissed";
        }
        
        $state = [count($ab_attendance),count($ex_attendance), count($pr_attendance), $status, $lec_num];
        return response()->json(['result' => $result, 'state' => $state]);
    }
    public function attendance()
    {
        return view('student/attendance');
    }
    public function excuse()
    {
        $t = User::findOrFail(auth::id());
        $data['rows'] = Excuse::orderBy('id', 'DESC')->where('student_id', $t->userable_id)->get();
        $data['rows2'] = Ill_Excuse::orderBy('id', 'DESC')->where('student_id', $t->userable_id)->get();
        return view('student/excuse')->with($data);
    }

    public function profile()
    {
        $t = User::findOrFail(auth::id());
        $data = Student::findOrFail($t->userable_id);
        $respond['data'] = $data;
        $addres = $data->addresses()->first();
        $respond['address'] = $addres;
        $accound = $data->user()->first();
        $respond['account'] = $accound;
        $mobile = $data->mobiles()->get();
        $respond['mobile'] = $mobile;
        $respond['collage'] = Collage::find($t->collage_id);
        $respond['major'] = Major::find($data->major_id);

        return view('student/profile')->with($respond);
    }
    public function updateProfile(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50',
                'major' => 'required|string|max:50',
                'collage' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:15',
                'mobile1' => 'required|string|max:15',
                'password' => 'required|string|max:20',
                'email' => 'required|email|string|unique:users'
            ]);
            $t = User::findOrFail(auth::id());
            $data = Student::findOrFail($t->userable_id);
            $data->name = $request->name;
            $data->major = $request->major;
            $data->collage = $request->collage;
            $data->save();
            $data->user()->first()->update(['email' => $request->email, 'password' => Hash::make($request->password)]);
            $data->addresses()->first()->where('addressable_id', $t->userable_id)->where('addressable_type', 'App\Student')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['data'] = $data;
            $addres = $data->addresses()->first();
            $respond['address'] = $addres;
            $accound = $data->user()->first();
            $respond['account'] = $accound;
            $mobile = $data->mobiles()->get();
            $respond['mobile'] = $mobile;
            return view('student/profile')->with($respond);
        }
    }
    public function chat()
    {
        return view('student.chat');
    }
    public function chat_send(Request $request)
    {$user = auth::user()->userable()->first();
        if ($request->reciever == 'Admin') {
            $sender = User::orderBy('id', 'DESC')->where('collage_id', auth::user()->collage_id)->where('userable_type', 'App\Admin')->first();
            broadcast(new SendMessage($user, $request->message, $sender->userable_id, 'Admin'));
            //sender,title,path,date
            $sender->notify(new \App\Notifications\ChatNotification($user->name, $request->message, 'chat.png', date('d-m-Y')));
        } elseif ($request->reciever == 'Dean') {
            $sender = User::orderBy('id', 'DESC')->where('collage_id', auth::user()->collage_id)->where('userable_type', 'App\Dean')->first();
            broadcast(new SendMessage($user, $request->message, $sender->userable_id, 'Dean'));
            $sender->notify(new \App\Notifications\ChatNotification($user->name, $request->message, 'chat.png', ''));
        }

        return response()->json(['success' => 'message send succefully']);
    }
    public function attend_self(Request $request)
    {
        Attendance::where('lec_id', $request->lecture)->where('student_id', $request->id)->update(['is_present' => true]);
        return response()->json(['result' => 'You are attend your self successfully']);
    }
}
