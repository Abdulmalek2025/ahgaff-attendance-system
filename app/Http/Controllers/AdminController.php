<?php

namespace App\Http\Controllers;

//app\Imports
use App\Address;
use App\Admin;
use App\Attachment;
use App\Attendance;
use App\Collage;
use App\Course;
use App\Dean;
use App\Excuse;
use App\Ill_Excuse;
use App\Imports\AddressesImport;
use App\Imports\MobilesImport;
use App\Imports\StudentsImport;
use App\Imports\UsersImport;
use App\Lecture;
use App\Mail\SendEmail;
use App\Major;
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
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public $file_name;
    public function __constructor()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        return view('admins/dashboard');
    }
    public function setup_dashboard()
    {
        $t = User::findOrFail(auth::id());
        $students_id = [];
        $i = 0;
        $groups_id = [];
        $j = 0;
        $students = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        foreach ($students as $student) {
            $students_id[$i] = $student->userable_id;
            $i++;
        }
        $groups = DB::table('student_groups')->whereIn('student_id', $students_id)->get();
        foreach ($groups as $group) {
            $groups_id[$j] = $group->group_id;
            $j++;
        }

        $courses = Sem_co::select('course_id')->whereIn('group_id', $groups_id)->distinct()->get();
        $groups = Sem_co::select('group_id')->whereIn('group_id', $groups_id)->distinct()->get();
        $semesters = Sem_co::select('semester_id')->whereIn('group_id', $groups_id)->distinct()->get();
        $data = Sem_co::orderBy('id', 'DESC')->whereIn('group_id', $groups_id)->with('course', 'group', 'semester', 'lectures', 'teacher')->get();
        return response()->json(array('rows' => $data, 'groups' => count($groups), 'courses' => count($courses), 'semesters' => count($semesters)));
    }
    public function index()
    {$admins = User::where('type', 'Admin')->get();
        $admins_id = [];
        $counter = 0;
        foreach ($admins as $admin) {
            $admins_id[$counter] = $admin->userable_id;
            $counter++;
        }
        $deans = User::where('type', 'Dean')->get();
        $deans_id = [];
        $counter = 0;
        foreach ($deans as $dean) {
            $deans_id[$counter] = $dean->userable_id;
            $counter++;
        }
        $data['rows'] = Admin::orderBy('id', 'DESC')->whereIn('id', $admins_id)->with('user')->get();
        $data['rows2'] = Dean::orderBy('id', 'DESC')->whereIn('id', $deans_id)->with('user')->get();
        $data['collages'] = Collage::orderBy('id', 'DESC')->get();
        return view('admins/admins')->with($data);
    }
    public function students()
    {$ids = [];
        $i = 0;
        $users = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        foreach ($users as $user) {
            $ids[$i] = $user->userable_id;
            $i++;
        }
        $data['rows'] = Student::orderBy('id', 'DESC')->whereIn('id', $ids)->get();
        $data['semesters'] = Semester::orderBy('id', 'DESC')->get();
        $data['majors'] = Major::orderBy('id', 'DESc')->where('collage_id', auth::user()->collage_id)->get();
        return view('admins/students')->with($data);
    }
    public function teachers()
    {
        $teachers = User::where('collage_id', auth::user()->collage_id)->where('type', 'Teacher')->get();
        $teachers_id = [];
        $counter = 0;
        foreach ($teachers as $teacher) {
            $teachers_id[$counter] = $teacher->userable_id;
            $counter++;
        }
        $data['rows'] = Teacher::whereIn('id', $teachers_id)->get();
        return view('admins/teachers')->with($data);
    }
    public function courses()
    {

        $data['rows'] = Course::orderBy('id', 'DESC')->where('collage_id', auth::user()->collage_id)->get();
        return view('admins/courses')->with($data);
    }
    public function groups()
    {
        // $data['rows'] = Teacher::orderBy('id','DESC')->get();
        return view('admins/groups');
    }
    public function semesters()
    {
        $data['rows'] = Semester::orderBy('id', 'DESC')->get();
        $data['collages'] = Collage::orderBy('id', 'DESC')->get();
        $data['majors'] = Major::orderBy('id', 'DESC')->with('collage')->get();
        return view('admins/semesters')->with($data);
    }
    public function attendances()
    {

        return view('admins/attendances');
    }
    public function excuses()
    {
        $students = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        $students_id = [];
        $i = 0;
        foreach ($students as $student) {
            $students_id[$i] = $student->userable_id;
            $i++;
        }
        $data['rows'] = Excuse::orderBy('id', 'DESC')->whereIn('student_id', $students_id)->get();
        $data['rows2'] = Ill_Excuse::orderBy('id', 'DESC')->whereIn('student_id', $students_id)->get();
        return view('admins/excuses')->with($data);
    }
    public function semester_course()
    {
        // $data['rows'] = Teacher::orderBy('id','DESC')->get();
        return view('admins/semester_course');
    }
    public function reports()
    {
        // $data['rows'] = Teacher::orderBy('id','DESC')->get();
        return view('admins/reports');
    }
    public function store(Request $request)
    {$check = User::where('userable_type', 'App\Dean')->where('collage_id', $request->collage)->count();
        if ($request->type == 'Admin') {
            if ($request->ajax()) {
                $request->validate([
                    'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                    'country' => 'required|string|max:50',
                    'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                    'street' => 'required|string|max:50',
                    'mobile' => 'required|string|max:10',
                    'mobile1' => 'required|string|max:10',
                    'email' => 'required|string|email|unique:users',
                    'collage' => 'required',
                    'type' => 'required',
                    'password' => 'required|string|confirmed|min:8',
                ]);
                $data = new Admin;
                $data->name = $request->name;
                $data->save();
                $data->user()->create(['email' => $request->email, 'type' => $request->type, 'password' => Hash::make($request->password), 'collage_id' => $request->collage]);
                $data->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
                $data->mobiles()->create(['mobile' => $request->mobile]);
                $data->mobiles()->create(['mobile' => $request->mobile1]);
                $respond['row'] = $data;
                return view('admins/row')->with($respond);

            }

        } elseif ($request->type == 'Dean' && $check == 0) {
            if ($request->ajax()) {
                $request->validate([
                    'name' => 'required|string|max:50',
                    'country' => 'required|string|max:50',
                    'city' => 'required|string|max:50',
                    'street' => 'required|string|max:50',
                    'mobile' => 'required|string|max:15',
                    'mobile1' => 'required|string|max:15',
                    'email' => 'required|string|email|unique:users',
                    'collage' => 'required',
                    'type' => 'required',
                    'password' => 'required|string|confirmed|min:8',
                ]);
                $data = new Dean;
                $data->name = $request->name;
                $data->save();
                $data->user()->create(['email' => $request->email, 'type' => $request->type, 'password' => Hash::make($request->password), 'collage_id' => $request->collage]);
                $data->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
                $data->mobiles()->create(['mobile' => $request->mobile]);
                $data->mobiles()->create(['mobile' => $request->mobile1]);
                $respond['row'] = $data;
                return view('admins/row')->with($respond);
            }

        } else {
            return response()->json(['error' => 'Dean is already exit!']);
        }

    }

    public function delete(Request $request)
    {if ($request->type == 'Admin') {
        $user = Admin::where('id', $request->id)->with('user')->first();
        Address::where('addressable_id', $request->id)->where('addressable_type', 'App\Admin')->delete();
        Mobile::where('mobileable_id', $request->id)->where('mobileable_type', 'App\Admin')->delete();
        DB::table('notifications')->where('notifiable_id', $user->user()->first()->id)->delete();
        Admin::findOrFail($request->id)->user()->delete();
        Admin::findOrFail($request->id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $request->id]);
    }

        if ($request->type == 'Dean') {
            $user = Dean::where('id', $request->id)->with('user')->first();
            Address::where('addressable_id', $request->id)->where('addressable_type', 'App\Dean')->delete();
            Mobile::where('mobileable_id', $request->id)->where('mobileable_type', 'App\Dean')->delete();
            DB::table('notifications')->where('notifiable_id', $user->user()->first()->id)->delete();
            Dean::findOrFail($request->id)->user()->delete();
            Dean::findOrFail($request->id)->delete();
            return response()->json(['success' => 'Deleted Success', 'id' => $request->id]);
        }
    }

    public function edit(Request $request)
    { //dd($request->type);
        if ($request->type == 'Admin') {
            $data = Admin::findOrfail($request->id);
            $user = $data->user()->first();
            $address = $data->addresses()->first();
            $mobile = $data->mobiles()->get()->where('mobileable_id', $request->id)->where('mobileable_type', 'App\Admin');
            return response()->json(array('data' => $data, 'user' => $user, 'address' => $address, 'mobile' => $mobile));
        } elseif ($request->type == 'Dean') {
            $data = Dean::findOrfail($request->id);
            $user = $data->user()->first();
            $address = $data->addresses()->first();
            $mobile = $data->mobiles()->get()->where('mobileable_id', $request->id)->where('mobileable_type', 'App\Dean');
            return response()->json(array('data' => $data, 'user' => $user, 'address' => $address, 'mobile' => $mobile));
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',

            ]);

            // dd($request->name);

            $data = Admin::findOrFail($request->id);
            $data->name = $request->name;
            $data->save();
            $data->addresses()->first()->where('addressable_id', $request->id)->where('addressable_type', 'App\Admin')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            if ($request->mobile1 != '') {
                $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);

            }
            $respond['row'] = $data;
            return view('Admins/rowEdit')->with($respond);
        }
    }
    public function search(Request $request)
    {

        $search_result = Admin::where('name', 'like', '%' . $request->search . '%')->with('addresses', 'mobiles')->get();
        $table = '';
        foreach ($search_result as $row) {
            $table .= '<tr id="' . $row->id . '">
            <td class="pl-2">' . $row->id . '</td>
            <td style="min-width:350px;">' . $row->name . '</td>
            <td>' . $row->addresses()->first()->city . '</td>
            <td>' . $row->mobiles()->first()->mobile . '</td>

            <td>
                <a href="#" class="edit-admin" data-toggle="modal" data-route="/admins/edit/' . $row->id . '"
                    data-target="#edit-admin-modal"><i class="bx bx-edit edit-color"></i></a>
                <a href="#" class="delete-admin" data-toggle="modal"
                    data-route="/admins/delete/' . $row->id . '"><i class="bx bxs-trash delete-color"></i></a>
            </td>
        </tr>';
        }
        /** */
        $search_result = Dean::where('name', 'like', '%' . $request->search . '%')->with('addresses', 'mobiles')->get();
        //$table = '';
        foreach ($search_result as $row) {
            $table .= '<tr id="' . $row->id . '">
            <td class="pl-2">' . $row->id . '</td>
            <td style="min-width:350px;">' . $row->name . '</td>
            <td>' . $row->addresses()->first()->city . '</td>
            <td>' . $row->mobiles()->first()->mobile . '</td>

            <td>
                <a href="#" class="edit-admin" data-toggle="modal" data-route="/admins/edit/' . $row->id . '"
                    data-target="#edit-admin-modal"><i class="bx bx-edit edit-color"></i></a>
                <a href="#" class="delete-admin" data-toggle="modal"
                    data-route="/admins/delete/' . $row->id . '"><i class="bx bxs-trash delete-color"></i></a>
            </td>
        </tr>';
        }
        return $data = array('row' => $table);
    }
    public function report_setup()
    {$user = auth::user();
        $courses = Course::where('collage_id', $user->collage_id)->get();
        $semesters = Semester::orderBy('id', 'ASC')->get();
        $course_ids = Course::select('id')->where('collage_id', $user->collage_id)->get();
        $ids = [];
        for ($i = 0; $i < count($course_ids); $i++) {
            $ids[$i] = $course_ids[$i]->id;
        }
        $sem_cos = Sem_co::where('semester_id', $semesters->first()->id)->whereIn('course_id', $ids)->with('course', 'teacher', 'group')->get();
        $lectures = [];
        $counter = 0;
        foreach ($sem_cos as $sem_co) {
            $lectures[$counter] = Lecture::where('sem_co_id', $sem_co->id)->count();
            $counter++;
        }
        $groups = null;
        if (count($ids) > 0) {
            $groups = Sem_co::where('course_id', $ids[0])->with('group')->get();
        }
        $majors = Major::where('collage_id', auth::user()->collage_id)->get();
        return response()->json(['semesters' => $semesters, 'sem_cos' => $sem_cos, 'lectures' => $lectures, 'courses' => $courses, 'groups' => $groups, 'majors' => $majors]);
    }
    public function semester_report(Request $request)
    {
        $user = auth::user();
        $course_ids = Course::select('id')->where('collage_id', $user->collage_id)->get();
        $ids = [];
        for ($i = 0; $i < count($course_ids); $i++) {
            $ids[$i] = $course_ids[$i]->id;
        }
        $sem_cos = Sem_co::where('semester_id', $request->id)->whereIn('course_id', $ids)->with('course', 'teacher', 'group')->get();
        $lectures = [];
        $counter = 0;
        foreach ($sem_cos as $sem_co) {
            $lectures[$counter] = Lecture::where('sem_co_id', $sem_co->id)->count();
            $counter++;
        }
        return response()->json(['sem_cos' => $sem_cos, 'lectures' => $lectures]);
    }
    public function course_report_setup()
    {
        return response()->json(['result' => 'ok']);

    }
    public function change_course(Request $request)
    {
        $groups = Sem_co::where('course_id', $request->id)->with('group')->get();
        return response()->json(['groups' => $groups]);
    }
    public function change_group(Request $request)
    {
        $user = auth::user();
        //group id and  course id
        ///find student,abcense,presence(with excuse or not),number of lectures
        $sem_co = Sem_co::where('course_id', $request->course_id)->where('group_id', $request->group_id)->with('lectures')->first();
        //lectures ids
        $lectures_id = [];
        $counter = 0;
        foreach ($sem_co->lectures()->get() as $lecture) {
            $lectures_id[$counter] = $lecture->id;
            $counter++;
        }
        //find the period of lectures
        $period = Lecture::whereIn('id', $lectures_id)->sum('period');
        $att = Attendance::whereIn('lec_id', $lectures_id)->with('student')->get();
        $students_id = [];
        $counter = 0;
        foreach ($att as $at) {
            $students_id[$counter] = $at->student_id;
            $counter++;
        } //delete duplicate

        $students_id = array_unique($students_id);
        $counter = 0;
        $result[][] = null;
        foreach ($students_id as $id) {
            $student_name = Student::find($id)->name;
            $presence = $att->where('student_id', $id)->where('is_present', 1)->count();
            $ex_absence = $att->where('student_id', $id)->where('is_present', 0)->where('attendanceable_type', 'none')->count();
            $absence = $att->where('student_id', $id)->where('is_present', 0)->whereIn('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->count();
            $result[$counter] = array($student_name, $presence, $ex_absence, $absence, count($lectures_id));
            $counter++;
        }
        return response()->json(['result' => $result]);

    }
    public function admin_tab_3_search(Request $request)
    {
        //return all students
        $students = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        $students_id = [];
        $i = 0;
        foreach ($students as $student) {
            $students_id[$i] = $student->userable_id;
            $i++;
        }

        $datas = Student::select('name')->whereIn('id', $students_id)->where('name', 'like', "%{$request->terms}%")->get();
        return response()->json($datas);
    }
    public function one_student_report(Request $request)
    {   
        $courses = [];$d=0;
        $student = Student::where('name',$request->search)->first();
        $mail = User::where('userable_type','App\Student')->where('userable_id',$student->student_id)->where('collage_id',auth::user()->collage_id)->first()->email;
        $groups = DB::table('student_groups')->where('student_id',$student->student_id)->get();
        $groups_id = [];$i = 0;
        foreach ($groups as $group) {
            $groups_id[$i] = $group->group_id;
            $i++;
        }
        $sem_cos = Sem_co::whereIn('group_id',$groups_id)->get();
        ##
        foreach ($sem_cos as $sem_co) {
            $lecs_id = [];
            $l = 0;
            foreach ($sem_co->lectures as $lec) {
                $lecs_id[$l] = $lec->id;
                $l++;
            }
            #
            $period = Lecture::select('period')->whereIn('id',$lecs_id)->sum('period');
            if($period == 0){
                $period = 1;
            }
            $lec_num = Attendance::whereIn('lec_id',$lecs_id)->where('student_id',$student->id)->count();
            $ab_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 0)->where('attendanceable_type', 'none')->whereIn('lec_id', $lecs_id)->with('lecture')->get();
            $ex_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 0)->whereIn('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->whereIn('lec_id', $lecs_id)->with('lecture')->get();
            $pr_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 1)->whereIn('lec_id', $lecs_id)->with('lecture')->get();
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
            #
            #$presence, $absence, $ex_absence, $lec_num
            if(in_array(array($sem_co->course()->first()->name,"Success"),$courses) || in_array(array($sem_co->course()->first()->name,"Dismissed"),$courses) || in_array(array($sem_co->course()->first()->name,"Forbidden"),$courses)){

            }else{
                $courses[$d] = array($sem_co->course()->first()->name,$pr_period,$ab_period,$ex_period,$lec_num,$status);
            }
            
            $d++;
        }
        ##
        return response()->json(['result' => $courses, 'mail' => $mail]);

    }
    public function mail(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'mail' => 'required|email|string',
                'subject' => 'required|string|max:50',
                'body' => 'required|string',

            ]);
            $name = Student::where('id', User::where('email', $request->mail)->first()->userable_id)->first()->name;
            Mail::to($request->mail)->send(new SendEmail($name, $request->subject, $request->body, $request->report));

            return response()->json(['success' => 'Your mail recieved successfully']);
        }

    }
    public function read(Request $request)
    {
        DB::table('notifications')->where('id', $request->id)->delete();
    }
    public function reset()
    { //only its collage
        $students = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        $students_id = [];
        $i = 0;
        $notifiable_id = [];
        $groups_id = [];
        $j = 0;
        $sem_cos_id = [];
        $c = 0;

        foreach ($students as $student) {
            $students_id[$i] = $student->userable_id;
            $notifiable_id[$i] = $student->id;
            $i++;
        }
        $groups = DB::table('student_groups')->whereIn('student_id', $students_id)->get();
        foreach ($groups as $group) {
            $groups_id[$j] = $group->group_id;
            $j++;
        }
        $sem_cos = Sem_co::whereIn('group_id', $groups_id)->get();
        foreach ($sem_cos as $sem_co) {
            $sem_cos_id[$c] = $sem_co->id;
            $c++;
        }
        $excuses = DB::table('excuses')->whereIn('student_id', $students_id)->get();
        $ill__excuses = DB::table('ill__excuses')->whereIn('student_id', $students_id)->get();

        DB::table('attendances')->whereIn('student_id', $students_id)->delete();
        DB::table('lectures')->whereIn('sem_co_id', $sem_cos_id)->delete();
        DB::table('excuses')->whereIn('student_id', $students_id)->delete();
        DB::table('ill__excuses')->whereIn('student_id', $students_id)->delete();
        DB::table('notifications')->whereIn('notifiable_id', $notifiable_id)->delete();
        DB::table('student_groups')->whereIn('student_id', $students_id)->delete();
        DB::table('users')->where('userable_type', 'App\Student')->whereIn('userable_id', $students_id)->delete();
        DB::table('addresses')->where('addressable_type', 'App\Student')->whereIn('addressable_id', $students_id)->delete();
        DB::table('mobiles')->where('mobileable_type', 'App\Student')->whereIn('mobileable_id', $students_id)->delete();
        DB::table('students')->whereIn('id', $students_id)->delete();
        return response()->json(['success' => 'Reset process completed']);
    }
    public function backup()
    {
        $backup_location = "E:\\backup\\";
        $file_name = date("Ymd") . "_backup.sql";
        $location = $backup_location . $file_name;
        exec("C:\\wamp64\\bin\\mysql\\mysql8.0.21\\bin\\mysqldump.exe -uroot project >" . $location);
        return response()->json(['success' => 'Your data backup successfully']);
    }
    public function restore(Request $request)
    {
        if (!empty($request->path)) {
            exec("mysql -uroot project < E:\\backup\\" . $request->path);
            return response()->json(['success' => 'Restored successfully']);
        } else {
            return response()->json(['success' => 'You must choose the file']);
        }

    }
    public function AddMaster(Request $request)
    {
        $file = file('admin.txt', FILE_IGNORE_NEW_LINES);
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'mastername' => 'required|string',
                'masterpassword' => 'required|string',

            ]);
            if ($file[0] == $request->mastername && $file[1] == $request->masterpassword) {
                $collage = Collage::get()->count();
                if ($collage > 0) {
                    $admin = new Admin;
                    $admin->name = $request->name;
                    $admin->save();
                    $admin->user()->create(['email' => $request->email, 'type' => 'Master', 'password' => Hash::make($request->password), 'collage_id' => 1]);
                    $admin->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
                    $admin->mobiles()->create(['mobile' => $request->mobile]);
                    $admin->mobiles()->create(['mobile' => $request->mobile1]);
                    return response()->json(['result' => 'success']);
                } else {
                    Collage::create(['name' => 'Global', 'location' => 'Global', 'telephone' => '000000']);
                    $admin = new Admin;
                    $admin->name = $request->name;
                    $admin->save();
                    $admin->user()->create(['email' => $request->email, 'type' => 'Master', 'password' => Hash::make($request->password), 'collage_id' => 1]);
                    $admin->addresses()->create(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
                    $admin->mobiles()->create(['mobile' => $request->mobile]);
                    $admin->mobiles()->create(['mobile' => $request->mobile1]);
                    return response()->json(['result' => 'success']);
                }
            } else {
                return response()->json(['result' => 'error']);
            }
        }
    }
    public function mreport()
    {
        $collages = Collage::get();
        $data = [[]];
        $adminNames = [];
        $admins_id = [];
        $nestedcounter = 0;
        $counter = 0;
        foreach ($collages as $collage) {
            $adminsd = User::where('type', 'Admin')->where('collage_id', $collage->id)->get();
            foreach ($adminsd as $admin) {
                $admins_id[$nestedcounter] = $admin->userable_id;
                $nestedcounter++;
            }
            $nestedcounter = 0;
            $dean = User::where('type', 'Dean')->where('collage_id', $collage->id)->first();
            $admins = Admin::whereIn('id', $admins_id)->get();
            $admins_id = [];
            $adminNames = [];
            foreach ($admins as $admin) {
                $adminNames[$nestedcounter] = $admin->name;
                $nestedcounter++;
            }
            $nestedcounter = 0;
            if ($dean) {
                if ($adminNames) {
                    $d = Dean::where('id', $dean->userable_id)->first();
                    $data[$counter] = array($collage->name, $collage->telephone, $d->name, $adminNames);
                    $counter++;
                } else {
                    $d = Dean::where('id', $dean->userable_id)->first();
                    $data[$counter] = array($collage->name, $collage->telephone, $d->name, '-');
                    $counter++;
                }

            } else {
                if ($adminNames) {
                    $data[$counter] = array($collage->name, $collage->telephone, '-', $adminNames);
                    $counter++;
                } else {
                    $data[$counter] = array($collage->name, $collage->telephone, '-', '-');
                    $counter++;
                }

            }
        }
        $datas['rows'] = $data;
        return view('admins.mreport')->with($datas);
    }
    public function upgrade()
    {
        $data['majors'] = Major::where('collage_id', auth::user()->collage_id)->get();
        $data['semesters'] = Semester::get();

        return view('admins.upgrade')->with($data);
    }
    public function change_major(Request $request)
    { //request data  =>major_id,semester_id

        $students = Student::where('semester_id', $request->semester_id)->where('major_id', $request->major_id)->get();
        return response()->json(['students' => $students]);
    }
    public function levelup(Request $request)
    {
        if (!is_null($request->status)) {
            $semester = Student::where('id', $request->status[0])->first()->semester_id;
            $number = Semester::get()->count();
            if ($semester < $number) {
                foreach ($request->status as $student_id) {
                    Student::where('id', $student_id)->update(['semester_id' => $semester + 1]);
                    DB::table('student_groups')->where('student_id', $student_id)->delete();
                    Attendance::where('student_id', $student_id)->delete();
                    $excuses = Excuse::where('student_id', $student_id)->get();
                    foreach ($excuses as $excuse) {
                        Attachment::where('attachmenable_type', 'App\Excuse')->where('attachmentable_id', $excuse->id) - delete();
                    }
                    Excuse::where('student_id', $student_id)->delete();
                    $ill_excuses = Ill_Excuse::where('student_id', $student_id)->get();
                    foreach ($ill_excuses as $ill_excuse) {
                        Attachment::where('attachmenable_type', 'App\Ill_Excuse')->where('attachmentable_id', $ill_excuse->id) - delete();
                    }
                    Ill_Excuse::where('student_id', $student_id)->delete();
                }
                $groups_id = [];
                $i = 0;
                $groups = DB::table('student_groups')->whereIn('student_id', $request->status)->get();
                foreach ($groups as $group) {
                    $groups_id[$i] = $group->group_id;
                    $i++;
                }
                $sem_cos = Sem_co::whereIn('group_id', $groups_id)->with('lectures')->delete();
                return response()->json(['success' => 'The process completed']);
            }
            return response()->json(['warning' => 'No next semester available']);
        } else {
            return response()->json(['error' => 'You must select student(s) to complete']);
        }
    }
    public function copy_data()
    {
        $backup_location = "E:\\backup\\";
        $file_name = date("Ymd") . "_backup.sql";
        $location = $backup_location . $file_name;
        exec("C:\\wamp64\\bin\\mysql\\mysql8.0.21\\bin\\mysqldump.exe -uroot project >" . $location);
        return response()->json(['success' => 'Your DataBase are copied successfully']);
    }
    public function import(Request $request)
    {if ($request->file('file')) {
        $file = $request->file('file');
        try {
            Excel::import(new StudentsImport(), $file);
            Excel::import(new AddressesImport(), $file);
            Excel::Import(new MobilesImport(), $file);
            Excel::Import(new UsersImport(), $file);
            return response()->json(['success' => 'Imported successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'There are duplicated rows in unique fields!']);
        }
    } else {
        return response()->json(['error' => 'You must select proper file with excel']);
    }

    }
    public function profile()
    {
        $data = Admin::findOrFail(Auth::user()->userable_id);
        $respond['data'] = $data;
        $addres = $data->addresses()->first();
        $respond['address'] = $addres;
        $accound = $data->user()->first();
        $respond['account'] = $accound;
        $mobile = $data->mobiles()->get();
        $respond['mobile'] = $mobile;
        $respond['file'] = file('admin.txt', FILE_IGNORE_NEW_LINES);
        return view('admins/profile')->with($respond);
    }
    public function updateProfile(Request $request)
    {if (Auth::user()->type == 'Master') {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',
                'password' => 'required|string|confirmed|max:20',
                'masterword' => 'required|string|',
                'masterpassword' => 'required|string',
                'email' => 'required|email|string|unique:users',
            ]);
            $data = Admin::findOrFail(Auth::user()->userable_id);
            $data->name = $request->name;
            $data->save();
            $data->user()->first()->update(['email' => $request->email, 'password' => Hash::make($request->password), 'collage_id' => Collage::where('name', $request->collage)->first()->id]);
            $data->addresses()->first()->where('addressable_id', Auth::user()->userable_id)->where('addressable_type', 'App\Dean')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['data'] = $data;
            $addres = $data->addresses()->first();
            $respond['address'] = $addres;
            $accound = $data->user()->first();
            $respond['account'] = $accound;
            $mobile = $data->mobiles()->get();
            $respond['mobile'] = $mobile;
            //$file = file('admin.txt',FILE_IGNORE_NEW_LINES);
            file_put_contents("admin.txt", "");
            $file = fopen("admin.txt", "a");
            fwrite($file, $request->masterword . PHP_EOL);
            fwrite($file, $request->masterpassword . PHP_EOL);
            $respond['file'] = file('admin.txt', FILE_IGNORE_NEW_LINES);
            return view('admins/profile')->with($respond);
        }

    } elseif (Auth::user()->type == 'Admin') {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:15',
                'mobile1' => 'required|string|max:15',
                'password' => 'required|string|confirmed|max:20',
                'email' => 'required|email|string|unique:users',
            ]);
            $data = Admin::findOrFail(Auth::user()->userable_id);
            $data->name = $request->name;
            $data->save();
            $data->user()->first()->update(['email' => $request->email, 'password' => Hash::make($request->password), 'collage_id' => Collage::where('name', $request->collage)->first()->id]);
            $data->addresses()->first()->where('addressable_id', Auth::user()->userable_id)->where('addressable_type', 'App\Dean')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['data'] = $data;
            $addres = $data->addresses()->first();
            $respond['address'] = $addres;
            $accound = $data->user()->first();
            $respond['account'] = $accound;
            $mobile = $data->mobiles()->get();
            $respond['mobile'] = $mobile;
            return view('admins/profile')->with($respond);
        }
    }

    }
    public function tab_4_report(Request $request)
    {
        //major,semester request
        $users_id = [];
        $m = 0;
        $users = User::where('userable_type', 'App\Student')->where('collage_id', auth::user()->collage_id)->get();
        foreach ($users as $user) {
            $users_id[$m] = $user->userable_id;
            $m++;
        }
        $students = Student::where('major_id', $request->major)->whereIn('student_id', $users_id)->where('semester_id', $request->semester)->get();
        $students_id = [];
        $i = 0;
        $groups_id = [];
        $j = 0;
        $lecs_id = [];
        $l = 0;
        $lecs = [];
        $d = 0;
        $courses = [];
        $c = 0;
        $report = [[]];
        $r = 0;
        foreach ($students as $student) {
            $groups = DB::table('student_groups')->where('student_id', $student->student_id)->get();
            foreach ($groups as $group) {
                $groups_id[$j] = $group->group_id;
                $j++;
            }
            $sem_cos = Sem_co::whereIn('group_id', $groups_id)->with('lectures')->get();
            $d = 0;
            $courses = [];
            foreach ($sem_cos as $sem_co) {
                $lecs_id = [];
                $l = 0;
                foreach ($sem_co->lectures as $lec) {
                    $lecs_id[$l] = $lec->id;
                    $l++;
                }
                #
                $period = Lecture::select('period')->whereIn('id',$lecs_id)->sum('period');
                if($period == 0){
                    $period = 1;
                }
                $ab_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 0)->where('attendanceable_type', 'none')->whereIn('lec_id', $lecs_id)->with('lecture')->get();
                $ex_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 0)->whereIn('attendanceable_type', ['App\Excuse', 'App\Ill_Excuse'])->whereIn('lec_id', $lecs_id)->with('lecture')->get();
                $pr_attendance = Attendance::where('student_id', $student->student_id)->where('is_present', 1)->whereIn('lec_id', $lecs_id)->with('lecture')->get();
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
                #
                
                if(in_array(array($sem_co->course()->first()->name,"Success"),$courses) || in_array(array($sem_co->course()->first()->name,"Dismissed"),$courses) || in_array(array($sem_co->course()->first()->name,"Forbidden"),$courses)){

                }else{
                    $courses[$d] = array($sem_co->course()->first()->name,$status,);
                }
                
                $d++;
            }#end sem_cos foreach
            $report[$r] = array('name'=>$student->name,'course'=>$courses);
            $r++;
        }#end student foreach

        return response()->json(['persons' => $report]);
    }
}
