<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Lecture;
use App\Sem_co;
use Auth;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $data['rows'] = Course::orderBy('id', 'DESC')->get();
        return view('courses/courses')->with($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'required|string|max:50',
                'credit' => 'required|numeric|min:0|max:5',
            ]);

            // dd($request->name);
            $user = auth::user();
            $data = new Course;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->credit = $request->credit;
            $data->collage_id = $user->collage_id;
            $data->save();
            $respond['row'] = $data;
            return view('courses/row')->with($respond);
        }
    }

    public function delete($id)
    {
        $sem_cos = Sem_co::where('course_id', $id)->get();
        $sem_co_ids = [];
        $counter = 0;
        foreach ($sem_cos as $key => $sem_co) {
            $sem_co_ids[$counter] = $sem_co->id;
            $counter++;
        }
        $lectures = Lecture::whereIn('sem_co_id', $sem_co_ids)->get();
        foreach ($lectures as $lecture) {
            Attendance::where('lec_id', $lecture->id)->delete();
        }
        Lecture::whereIn('sem_co_id', $sem_co_ids)->delete();
        Sem_co::where('course_id', $id)->delete();
        Course::findOrfail($id)->delete();
        return response()->json(['success' => 'Deleted Success', 'id' => $id]);
    }

    public function edit($id)
    {
        $data = Course::findOrfail($id);
        return response()->json(array('data' => $data));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'required|string|max:50',
                'credit' => 'required|numeric|min:0|max:5',
            ]);

            // dd($request->name);
            $user = auth::user();
            $data = Course::findOrFail($request->id);
            $data->name = $request->name;
            $data->description = $request->description;
            $data->credit = $request->credit;
            $data->collage_id = $user->collage_id;
            $data->save();
            $respond['row'] = $data;
            return view('courses/rowEdit')->with($respond);
        }
    }
}
