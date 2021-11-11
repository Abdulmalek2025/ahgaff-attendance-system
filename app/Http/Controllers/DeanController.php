<?php

namespace App\Http\Controllers;

use App\Dean;
use App\Excuse;
use App\Ill_Excuse;
use App\Student;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeanController extends Controller
{
    public function dashboard()
    {
        return view('dean/dashboard');
    }
    public function profile()
    {
        $t = User::findOrFail(auth::id());
        $data = Dean::findOrFail($t->userable_id);
        $respond['data'] = $data;
        $addres = $data->addresses()->first();
        $respond['address'] = $addres;
        $accound = $data->user()->first();
        $respond['account'] = $accound;
        $mobile = $data->mobiles()->get();
        $respond['mobile'] = $mobile;

        return view('dean/profile')->with($respond);
    }
    public function update_profile(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50|regex:(^[a-zA-Z\s]+$)',
                'street' => 'required|string|max:50',
                'mobile' => 'required|string|max:10',
                'mobile1' => 'required|string|max:10',
                'password' => 'required|string|max:20',
                'email' => 'required|email|string|unique:users'
            ]);
            $t = User::findOrFail(auth::id());
            $data = Dean::findOrFail($t->userable_id);
            $data->name = $request->name;
            $data->save();
            $data->user()->first()->update(['email' => $request->email, 'password' => Hash::make($request->password), 'collage_id' => Collage::where('name', $request->collage)->first()->id]);
            $data->addresses()->first()->where('addressable_id', $t->userable_id)->where('addressable_type', 'App\Dean')->update(['country' => $request->country, 'city' => $request->city, 'street' => $request->street]);
            $data->mobiles()->first()->update(['mobile' => $request->mobile]);
            $data->mobiles()->get()->last()->update(['mobile' => $request->mobile1]);
            $respond['data'] = $data;
            $addres = $data->addresses()->first();
            $respond['address'] = $addres;
            $accound = $data->user()->first();
            $respond['account'] = $accound;
            $mobile = $data->mobiles()->get();
            $respond['mobile'] = $mobile;
            return view('dean/profile')->with($respond);
        }
        //redirect
    }
    public function excuse()
    {
        $students = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Student')->get();
        $ar = [];$i = 0;
        foreach ($students as $student) {
            $ar[$i] = $student->userable_id;
            $i++;
        }
        $data['rows'] = Excuse::orderBy('id', 'DESC')->whereIn('student_id', $ar)->get();
        $data['rows2'] = Ill_Excuse::orderBy('id', 'DESC')->whereIn('student_id', $ar)->get();
        return view('dean/excuses')->with($data);
    }
    public function report()
    {

        return view('dean/reports');
    }
}
