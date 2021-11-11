<?php

namespace App\Http\Controllers;

use App\Collage;
use App\Major;
use App\Semester;
use App\Student;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $data['rows'] = Semester::orderBy('id', 'DESC')->get();
        $data['collages'] = Collage::orderBy('id', 'DESC')->get();
        $data['majors'] = Major::orderBy('id', 'DESC')->with('collage')->get();
        return view('semesters/semesters')->with($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'start_date' => 'required|Date|before:end_date',
                'end_date' => 'required|Date|after:start_date',
            ]);

            $check = Semester::where('name', $request->name)->first();

            if (is_null($check)) {
                $data = new Semester;
                $data->name = $request->name;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->save();
                $respond['row'] = $data;
                return view('semesters/row')->with($respond);
            } else {
                return response()->json(['error' => 'This row already exit']);
            }

        }
    }

    public function delete($id)
    {
        Semester::findOrfail($id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }

    public function edit($id)
    {
        $data = Semester::findOrfail($id);
        return response()->json(array('data' => $data));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {$state = '';
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'start_date' => 'required|Date|before:end_date',
                'end_date' => 'required|Date|after:start_date',
            ]);
            //$check = Semester::where('name', $request->name)->first();
            // dd($request->name);
                $data = Semester::findOrFail($request->id);
                $data->name = $request->name;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->save();
                $respond['row'] = $data;
                return view('semesters/rowEdit')->with($respond);
        }
    }
    /**collages */
    public function collage_store(Request $request)
    {
        if ($request->ajax()) {$state = '';
            $request->validate([
                'collage' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'location' => 'required|string|max:50',
                'telephone' => 'required|string|max:10',
            ]);
            $check = Collage::where('name', $request->collage)->first();
            if (is_null($check)) {
                $data = new Collage;
                $data->name = $request->collage;
                $data->location = $request->location;
                $data->telephone = $request->telephone;
                $data->save();
                $respond['row'] = $data;
                return view('collages/row')->with($respond);
            } else {
                $state = 'This row is already exit';
                return response()->json(['state' => $state]);
            }

        }
    }

    public function collage_delete($id)
    {
        $majorsIn = Major::where('collage_id', $id)->get();
        $majorsId = [];
        $counter = 0;
        foreach ($majorsIn as $majorIn) {
            $majorsId[$counter] = $majorIn->id;
            $counter++;
        }
        //**/
        $students = Student::whereIn('major_id', $majorsId)->get();
        foreach ($students as $student) {
            $u = User::where('userable_id', $student->id)->where('userable_type', 'App\Student')->first();
            if (DB::table('notifications')->where('notifiable_id', $u->id)->count() > 0) {
                $u->notifications()->delete();
            }
            Student::findOrFail($student->id)->user()->delete();
            DB::table('student_groups')->where('student_id', $student->id)->delete();
            Mobile::where('mobileable_id', $student->id)->where('mobileable_type', 'App\Student')->delete();
            Attendance::where('student_id', $student->id)->delete();
            Student::findOrFail($student->id)->addresses()->delete();
            Student::findOrFail($student->id)->delete();
        }
        Major::whereIn('id', $majorsId)->delete();
        /** */

        Collage::findOrfail($id)->delete();
        $majors = Major::get();
        $collages = Collage::orderBy('id', 'DESC')->get();
        return response()->json(['success' => 'Deleted Success', 'id' => $id, 'collages' => $collages, 'majors' => $majors]);
    }

    public function collage_edit($id)
    {
        $data = Collage::where('id', $id)->first();
        return response()->json(array('data' => $data));
    }
    public function collage_update(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'update_collage_name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'update_collage_location' => 'required|string|max:50',
                'update_collage_telephone' => 'required|string|max:10',
            ]);

            $data = Collage::findOrFail($request->collage_id);
            $data->name = $request->update_collage_name;
            $data->location = $request->update_collage_location;
            $data->telephone = $request->update_collage_telephone;
            $data->save();
            $respond['row'] = $data;
            return view('collages/rowEdit')->with($respond);
        }
    }
    /**majors */
    public function major_store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'major_name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'major_collages' => 'required',
            ]);

            // dd($request->name);
            $row = Major::where('name', $request->major_name)->where('collage_id', $request->major_collages)->first();
            if (is_null($row)) {
                $data = new Major;
                $data->name = $request->major_name;
                $data->collage_id = $request->major_collages;
                $data->save();
                $respond['row'] = $data;
                return view('majors/row')->with($respond);
            } else {
                return response()->json(['state' => 'This row already exit']);
            }

        }
    }
    public function collages()
    {
        $collages = Collage::orderBy('id', 'DESC')->get();
        return response()->json(['new_collages' => $collages]);
    }

    public function major_delete($id)
    {
        $students = Student::where('major_id', $id)->get();
        foreach ($students as $student) {
            $u = User::where('userable_id', $student->id)->where('userable_type', 'App\Student')->first();
            if (DB::table('notifications')->where('notifiable_id', $u->id)->count() > 0) {
                $u->notifications()->delete();
            }
            Student::findOrFail($student->id)->user()->delete();
            DB::table('student_groups')->where('student_id', $student->id)->delete();
            Mobile::where('mobileable_id', $student->id)->where('mobileable_type', 'App\Student')->delete();
            Attendance::where('student_id', $student->id)->delete();
            Student::findOrFail($student->id)->addresses()->delete();
            Student::findOrFail($student->id)->delete();
        }
        Major::findOrfail($id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }

    public function major_edit($id)
    {
        $data = Major::where('id', $id)->with('collage')->first();
        $collages = Collage::orderBy('id', 'DESC')->get();
        return response()->json(array('data' => $data, 'collages' => $collages));
    }

    public function major_update(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'update_major_name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'update_major_collages' => 'required',
            ]);

            $data = Major::findOrFail($request->major_id);
            $data->name = $request->update_major_name;
            $data->collage_id = $request->update_major_collages;
            $data->save();
            $respond['row'] = $data;
            return view('majors/rowEdit')->with($respond);
        }
    }
}
