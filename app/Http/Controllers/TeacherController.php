<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Events\StudentAttendSelf;
use App\Events\StudentOpenLecture;
use App\Group;
use App\Lecture;
use App\Mobile;
use App\Semester;
use App\Sem_co;
use App\Student;
use App\Teacher;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $data['rows'] = Teacher::orderBy('id', 'DESC')->get();
        return view('teachers/teachers')->with($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'major' => 'required|string|max:50',
                'degree' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',
                'email' => 'required|email|string|unique:users',
            ]);

            // dd($request->name);
            $t = User::findOrFail(auth::id());
            $data = new Teacher;
            $data->name = $request->name;
            $data->major = $request->major;
            $data->degree = $request->degree;
            $data->save();
            $data->user()->create(['email' => $request->email, 'password' => Hash::make('00000000'), 'type' => 'Teacher', 'collage_id' => $t->collage_id]);
            $data->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->create(['mobile' => $request->mobile]);
            $data->mobiles()->create(['mobile' => $request->mobile1]);
            $respond['row'] = $data;
            return view('teachers/row')->with($respond);
        }
    }

    public function delete($id)
    {$sem_cos = Sem_co::where('teacher_id', $id)->with('lectures')->get();
        $sem_id = [];
        $counter = 0;
        foreach ($sem_cos as $sem_co) {
            $sem_id[$counter] = $sem_co->id;
            $counter++;
        }
        $lecs = Lecture::whereIn('sem_co_id', $sem_id)->get();
        $lec_id = [];
        $counter = 0;
        foreach ($lecs as $lec) {
            $lec_id[$counter] = $lec;
            $counter++;
        }
        Attendance::whereIn('lec_id', $lec_id)->delete();
        Lecture::whereIn('id', $lec_id)->delete();
        Sem_co::whereIn('id', $sem_id)->delete();
        $u = User::where('userable_id', $id)->where('userable_type', 'App\Teacher')->with('notifications')->get();
        if ($u->first()->notifications()->count() > 0) {
            $u->first()->notifications()->delete();
        }

        Sem_co::where('teacher_id', $id)->delete();
        Teacher::findOrFail($id)->addresses()->delete();
        Mobile::where('mobileable_id', $id)->where('mobileable_type', 'App\Teacher')->delete();
        Teacher::findOrFail($id)->user()->delete();

        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }

    public function edit($id)
    {
        $data = Teacher::findOrfail($id);
        $user = $data->user()->first();
        $address = $data->addresses()->first();
        $mobile = $data->mobiles()->get()->where('mobileable_id', $id);
        return response()->json(array('data' => $data, 'address' => $address, 'mobile' => $mobile, 'user' => $user));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'major' => 'required|string|max:50',
                'degree' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',
            ]);

            // dd($request->name);

            $data = Teacher::findOrFail($request->id);
            $data->name = $request->name;
            $data->major = $request->major;
            $data->degree = $request->degree;
            $data->save();
            $data->addresses()->first()->where('addressable_id', $request->id)->where('addressable_type', 'App\Teacher')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['row'] = $data;
            return view('teachers/rowEdit')->with($respond);
        }
    }
    public function setup()
    {
        $t = User::findOrFail(auth::id());
        $courses = Sem_co::select('course_id')->where('teacher_id', $t->userable_id)->distinct()->get();
        $groups = Sem_co::select('group_id')->where('teacher_id', $t->userable_id)->distinct()->get();
        $semesters = Sem_co::select('semester_id')->where('teacher_id', $t->userable_id)->distinct()->get();
        $data = Sem_co::where('teacher_id', $t->userable_id)->with('course', 'group', 'semester', 'lectures')->get();
        return response()->json(array('rows' => $data, 'groups' => count($groups), 'courses' => count($courses), 'semesters' => count($semesters)));
    }
    public function dashboard()
    {
        return view('teacher/dashboard');
    }

    public function confirm(Request $request)
    {
        $sem_co = Sem_co::where('id', $request->sem_co)->with('group', 'course', 'teacher', 'semester', 'lectures')->first();
        $lecture = Lecture::where('id', $request->lecture_id)->first();
        $att = Attendance::where('lec_id', $request->lecture_id)->with('student')->get();
        $number = Attendance::where('lec_id', $request->lecture_id)->where('is_present', 1)->count();
        $data['lec'] = $lecture;
        $data['att'] = $att;
        $data['sem_co'] = $sem_co;
        $data['number'] = $number;
        return view('teacher/confirm')->with($data);
    }
    public function filter_lec(Request $request)
    {
        $lec = Lecture::orderBy('id', 'DESC')->where('sem_co_id', $request->id)->get();
        $l = Lecture::orderBy('id', 'DESC')->where('sem_co_id', $request->id)->first();
        $att = Attendance::where('lec_id', $l->id)->with('student')->get();
        return response()->json(array('lec' => $lec, 'att' => $att));
    }
    public function filter_attendance(Request $request)
    {
        $att = Attendance::orderBy('id', 'DESC')->where('lec_id', $request->id)->with('student')->get();

        return response()->json(array('att' => $att));
    }
    public function update_confirm(Request $request)
    {
        if ($request->status == null) {

        } else if ($request->status != null) {
            foreach($request->status as $state){
                Attendance::where('lec_id', $request->lec)->where('student_id', $state)->update(['is_present' => 1]);
            }
        }
        Lecture::where('id', $request->lec)->update(['close_time' => date('Y-m-d H:i:s')]);
    }
    public function lecture()
    {$sem_cos = Sem_co::where('teacher_id', auth::user()->userable_id)->get();
        $lec = null;
        $one = null;
        $current_date = date('Y-m-d H:i:s');
        $t1 = strtotime($current_date);

        foreach ($sem_cos as $l) {
            $test = Lecture::where('sem_co_id', $l->id)->get();
            foreach ($test as $t) {
                $t2 = strtotime($t->created_at);
                $diff = $t1 - $t2;
                $hours = $diff / (60 * 60);
                if ($hours >= $t->period && $t->close_time == null) {
                    $new_time = date("Y-m-d H:i:s", strtotime('+' . $t->period . ' hours', strtotime($t->created_at)));
                    $t->close_time = $new_time;
                    $t->save();
                }
            }
        }
        foreach ($sem_cos as $sem) {
            $lec = Lecture::where('sem_co_id', $sem->id)->where('close_time', null)->first();
            if ($lec != null) {
                break;
            }
        }
        if ($lec == null) {
            $check = null;
        } else {
            $check = $lec;
        }
        $sem_co['check'] = $check;
        $sem_co['rows'] = Sem_co::where('teacher_id', auth::user()->userable_id)->with('group', 'course', 'teacher', 'semester');
        return view('teacher/lecture')->with($sem_co);

    }

    public function profile()
    {
        $t = User::findOrFail(auth::id());
        $data = Teacher::findOrFail($t->userable_id);
        $respond['data'] = $data;
        $addres = $data->addresses()->first();
        $respond['address'] = $addres;
        $accound = $data->user()->first();
        $respond['account'] = $accound;
        $mobile = $data->mobiles()->get();
        $respond['mobile'] = $mobile;

        return view('teacher/profile')->with($respond);
    }
    public function updateProfile(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'major' => 'required|string|max:50',
                'degree' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:15',
                'mobile1' => 'required|string|max:15',
                'password' => 'required|string|max:20',
                'email' => 'required|email|string|unique:users'
            ]);
            $t = User::findOrFail(auth::id());
            $data = Teacher::findOrFail($t->userable_id);
            $data->name = $request->name;
            $data->major = $request->major;
            $data->degree = $request->degree;
            $data->save();
            $data->user()->first()->update(['email' => $request->email, 'password' => Hash::make($request->password)]);
            $data->addresses()->first()->where('addressable_id', $t->userable_id)->where('addressable_type', 'App\Teacher')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['data'] = $data;
            $addres = $data->addresses()->first();
            $respond['address'] = $addres;
            $accound = $data->user()->first();
            $respond['account'] = $accound;
            $mobile = $data->mobiles()->get();
            $respond['mobile'] = $mobile;
            return view('teacher/profile')->with($respond);
        }
        //redirect
    }
    public function reports()
    {
        return view('teacher/reports');
    }
    public function open(Request $request)
    {
        if($request->ajax())
        {
            $request->validate([
                'type' =>'required',
                'sem_co' =>'required',
                'period' =>'required|numeric',
            ]);
            if($request->type == 'Teacher only'){
                //course,teacher,students_id,date
                Lecture::create(['period'=>$request->period,'sem_co_id'=>$request->sem_co,'att_type'=>$request->type, 'close_time'=>null]);
                $sem_co = Sem_co::where('id',$request->sem_co)->with('group','course','teacher','lectures')->get();
                $course = $sem_co->first()->course()->first()->name;
                $teacher = $sem_co->first()->teacher()->first()->name;
                $date = Lecture::orderBy('created_at','DESC')->first()->created_at;
                $student_id = DB::table('student_groups')->select('student_id')->where('group_id',$sem_co->first()->group()->first()->id)->get();
                broadcast(new StudentOpenLecture($course, $teacher, $student_id, $date));
            }else if($request->type == 'With student'){
                Lecture::create(['period'=>$request->period,'sem_co_id'=>$request->sem_co,'att_type'=>$request->type, 'close_time'=>null]);
                $sem_co = Sem_co::where('id',$request->sem_co)->with('group','course','teacher','lectures')->get();
                $course = $sem_co->first()->course()->first()->name;
                $teacher = $sem_co->first()->teacher()->first()->name;
                $lec_id = Lecture::orderBy('created_at','DESC')->first()->id;
                $date = Lecture::orderBy('created_at','DESC')->first()->created_at;
                $student_id = DB::table('student_groups')->select('student_id')->where('group_id',$sem_co->first()->group()->first()->id)->get();
                broadcast(new StudentAttendSelf($lec_id, $teacher, $student_id, $date,$course));
            }else if($request->type == 'Fingerprint'){
                Lecture::create(['period'=>$request->period,'sem_co_id'=>$request->sem_co,'att_type'=>$request->type, 'close_time'=>null]);
                $sem_co = Sem_co::where('id',$request->sem_co)->with('group','course','teacher','lectures')->get();
                $course = $sem_co->first()->course()->first()->name;
                $teacher = $sem_co->first()->teacher()->first()->name;
                $date = Lecture::orderBy('created_at','DESC')->first()->created_at;
                $student_id = DB::table('student_groups')->select('student_id')->where('group_id',$sem_co->first()->group()->first()->id)->get();
                broadcast(new StudentOpenLecture($course, $teacher, $student_id, $date));
            }
            $group = Sem_co::where('id',(int)$request->sem_co)->first();
            $lecture = Lecture::latest()->where('sem_co_id',$request->sem_co)->first();
            $students = Group::where('id',(int)$group->group_id)->with('user')->first();
            foreach($students->user as $st){
                Attendance::create(['lec_id'=>$lecture->id,'student_id'=>$st->id,'group_id'=>$group->group_id,'is_present'=>false]);
            }
            return response()->json(array('students'=>$students, 'type'=>$request->type, 'lecture_id'=>$lecture->id));
        }
    }
    public function setSemCo(Request $request)
    {
        $sem_cos = Sem_co::where('teacher_id', auth::user()->userable_id)->get();
        $lec = null;
        $one = null;
        foreach ($sem_cos as $sem) {
            $lec = Lecture::where('sem_co_id', $sem->id)->where('close_time', null)->first();
            if ($lec != null) {
                break;
            }
        }
        if ($lec != null) {
            $one = Sem_co::where('id', $lec->sem_co_id)->with('course', 'teacher', 'semester', 'group')->first();
        }
        $sem = Sem_co::where('teacher_id', auth::user()->userable_id)->with('course', 'teacher', 'semester', 'group')->get();
        return response()->json(array('sem' => $sem, 'one' => $one));
    }
    public function set()
    {
        //$t = User::findOrFail(auth::id());
        $semesters = Semester::orderBy('id', 'DESC')->get();
        $counter = Sem_co::where('teacher_id', auth::user()->userable_id)->with('course')->get();
        $lecs = Lecture::where('sem_co_id', $counter->first()->id)->with('attendances')->get();
        $total = Lecture::where('sem_co_id', $counter->first()->id)->sum('period');
        return response()->json(array('setupData' => $counter, 'setupLec' => $lecs, 'setupTotal' => $total, 'semesters' => $semesters));
    }
    public function report_semester_courses(Request $request)
    { //$array = null;
        $t = User::findOrFail(auth::id());
        $counter = Sem_co::where('teacher_id', $t->userable_id)->where('semester_id', $request->id)->with('course')->get();
        return response()->json(array('data' => $counter));
    }
    public function course_report()
    {
        //$user = auth::user();
        $sem_cos = Sem_co::where('teacher_id', auth::user()->userable_id)->with('course', 'semester', 'group', 'teacher', 'lectures')->get();
        return response()->json(['sem_cos' => $sem_cos]);
    }
    public function semester_course_change(Request $request)
    {
        $sem_co = Sem_co::where('id', $request->id)->with('lectures')->first();
        return response()->json(['sem_co' => $sem_co]);
    }
    public function report_for_one_sem_co(Request $request)
    {
        $lecs = Lecture::where('sem_co_id', $request->id)->with('attendances')->get();
        $total = Lecture::where('sem_co_id', $request->id)->sum('period');
        return response()->json(array('lec' => $lecs, 'total' => $total));
    }
    public function tab_3_search(Request $request)
    {   $sem_cos = Sem_co::where('teacher_id',auth::user()->userable_id)->get();
        $groups_id = [];$i = 0;
        foreach ($sem_cos as $sem_co) {
            $groups_id[$i] = $sem_co->group_id;
            $i++;
        }
        $studentGroups = DB::table('student_groups')->whereIn('group_id',$groups_id)->get();
        $students_id = [];$j = 0;
        foreach ($studentGroups as $studentGroup) {
            $students_id[$j] = $studentGroup->student_id;
            $j++;
        }
        $datas = Student::select('name')->whereIn('id',$students_id)->where('name', 'like', "%{$request->terms}%")->get();
        return response()->json($datas);
    }
    public function one_student_report(Request $request)
    {
        $student = Student::where('name', $request->search)->first();
        $att = Attendance::where('student_id', $student->id)->get();
        $lectures_id = [];
        $counter = 0;
        $total_period = 0;
        foreach ($att as $at) {
            $lectures_id[$counter] = $at->lec_id;
            $counter++;
        }
        $sem_cos = Lecture::whereIn('id', $lectures_id)->get();
        $sem_cos_id = [];
        $counter = 0;
        foreach ($sem_cos as $sem_co) {
            $sem_cos_id[$counter] = $sem_co->sem_co_id;
            $counter++;
        }
        $sem_cos_id = array_unique($sem_cos_id);
        $counter = 0;
        $counter1 = 0;
        $count = 0;
        $counter2 = 0;
        $result = [[]];
        $lecture_ids = [];
        $lec_ids;
        $total_period = 0;
        //loop of each  sem_co id
        foreach ($sem_cos_id as $id) {
            $lec_id = Lecture::where('sem_co_id', $id)->get();
            foreach ($lec_id as $lec) {
                $lecture_ids[$counter2] = $lec->id;
                $total_period += $lec->period;
                $counter2++;
            }
            /** */
            $ab_attendance = Attendance::where('student_id', $student->id)->where('is_present', 0)->where('attendanceable_type', 'none')->whereIn('lec_id', $lecture_ids)->with('lecture')->get();
            $ex_attendance = Attendance::where('student_id', $student->id)->where('is_present', 0)->where('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->whereIn('lec_id', $lecture_ids)->with('lecture')->get();
            $pr_attendance = Attendance::where('student_id', $student->id)->where('is_present', 1)->whereIn('lec_id', $lecture_ids)->with('lecture')->get();
            $ab_period = 0;
            $ex_period = 0;
            $pr_period = 0;
            if (count($ab_attendance) > 0) {
                foreach ($ab_attendance as $ab_at) {
                    $ab_period += $ab_at->lecture()->first()->period;
                }
            }
            if (count($ex_attendance) > 0) {
                foreach ($ex_attendance as $ab_at) {
                    $ex_period += $ab_at->lecture()->first()->period;
                }
            }
            if (count($pr_attendance) > 0) {
                foreach ($pr_attendance as $ab_at) {
                    $pr_period += $ab_at->lecture()->first()->period;
                }
            }
            /** */
            $absence = Attendance::whereIn('lec_id', $lecture_ids)->where('is_present', 0)->where('attendanceable_type', 'none')->where('student_id', $student->id)->count();
            $ex_absence = Attendance::whereIn('lec_id', $lecture_ids)->where('is_present', 0)->whereIn('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->where('student_id', $student->id)->count();
            $presence = Attendance::whereIn('lec_id', $lecture_ids)->where('is_present', 1)->where('student_id', $student->id)->count();
            $lec_num = Attendance::whereIn('lec_id', $lecture_ids)->where('student_id', $student->id)->count();
            if ((($ex_period / $total_period) * 100 + ($ab_period / $total_period) * 100) <= 20 || ($ab_period / $total_period) * 100 <= 10) {
                $status = "Success";
            } elseif (((($ex_period / $total_period) * 100 + ($ab_period / $total_period) * 100) > 20 && (($ex_period / $total_period) * 100 + ($ab_period / $total_period) * 100) < 70) || ($ab_period / $total_period) * 100 > 10 && ($ab_period / $total_period) * 100 <= 70) {
                $status = "Forbidden";
            } elseif ((($ex_period / $total_period) * 100 + ($ab_period / $total_period) * 100) >= 70 || (($ab_period / $total_period) * 100) >= 70) {
                $status = "Dismissed";
            }
            $course_name = Sem_co::find($id)->course()->first()->name;
            $result[$counter] = array($course_name, $presence, $absence, $ex_absence, $lec_num, $status);
            $counter++;

        }
        return response()->json(['result' => $result]);
    }
    public function search(Request $request)
    {
        $search_result = Teacher::where('name', 'like', '%' . $request->search . '%')->with('addresses', 'mobiles')->get();
        $table = '';
        foreach ($search_result as $row) {
            $table .= '<tr id="' . $row->id . '">
            <td class="pl-2">' . $row->id . '</td>
            <td style="min-width:350px;">' . $row->name . '</td>
            <td>' . $row->addresses()->first()->city . '</td>
            <td>' . $row->mobiles()->first()->mobile . '</td>

            <td>
                <a href="#" class="edit-teacher" data-toggle="modal" data-route="/teachers/edit/' . $row->id . '"
                    data-target="#edit-teacher-modal"><i class="bx bx-edit edit-color"></i></a>
                <a href="#" class="delete-teacher" data-toggle="modal"
                    data-route="/teachers/delete/' . $row->id . '"><i class="bx bxs-trash delete-color"></i></a>
            </td>
        </tr>';
        }
        return $data = array('row' => $table);
    }
    public function delete_lecture(Request $request)
    {
        Attendance::where('lec_id', $request->id)->delete();
        Lecture::where('id', $request->id)->delete();
        $sem_cos = Sem_co::where('teacher_id', auth::user()->userable_id)->with('group', 'course', 'teacher', 'semester')->get();
        return response()->json(['id' => $request->id, 'sem_cos' => $sem_cos]);
    }
    public function lecture_detail(Request $request)
    {
        $lec = Lecture::where('id', $request->id)->with('sem_co')->first();
        $att['lec'] = $lec;
        $att['atts'] = Attendance::where('lec_id', $request->id)->with('student')->get();
        return view('teacher.detail')->with($att);
    }
}
