<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Attendance;
use App\Excuse;
use App\Ill_Excuse;
use App\Attachment;
use Auth;
use App\User;
use App\Dean;
use App\Admin;
use App\Events\AdminExcuse;
use App\Events\DeanExcuse;
use App\Student;
use App\Events\StudentExcusePaid;
use App\Events\StudentExcuseAccepted;
class ExcuseController extends Controller
{
    public function store(Request $request)
    {
        if($request->type == 'Ill' ){
            if($request->ajax())
        {/**update-student_id,update-title, update-description,
             update-start_date, update-end_date, update-doctor, update-hospital,
            update-address,update-money,update-status, update-attachment */
            $request->validate([
                'student_id' =>'required|string|max:50',
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'doctor' =>'string|required',
                'hospital' =>'string|required',
                'address' =>'string|required',
                'status' =>'string|required',
                'attachment' =>'required|image',
            ]);
            $date1 = strtotime($request->start_date);
            $date2 = strtotime($request->end_date);
            //dd(($date2 - $date1)/86400);
            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = new Ill_Excuse;
            $data->student_id = $request->student_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->money = $request->money;
            $data->doctor = $request->doctor;
            $data->hospital = $request->hospital;
            $data->address = $request->address;
            $data->status = $request->status;
            $data->save();
            $data->attachments()->create(['path'=>$file_name]);
            $respond['row'] = $data;
            return view('excuses/ill_row')->with($respond);
        }
    }else if($request->type == 'Other'){
            if($request->ajax())
        {
            $request->validate([
                'student_id' =>'required|string|max:50',
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' =>'string|required',
                'attachment' =>'required|image',
            ]);
            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = new Excuse;
            $data->student_id = $request->student_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->money = $request->money;
            $data->status = $request->status;
            $data->save();
            $attach = $data->attachments()->create(['path'=>$file_name]);
            $respond['row'] = $data;
            return view('excuses/row')->with($respond);
        }
    }
    }

    public function delete(Request $request)
    {   if($request->type == 'Ill'){
        Ill_Excuse::findOrfail($request->id)->delete();
    }else if($request->type == 'Other'){
        Excuse::findOrfail($request->id)->delete();
    }

        return response()->json(['success'=>'Deleted Success'.$request->type.'','id'=>$request->id]);
    }
    public function edit(Request $request)
    {   if($request->type == 'Ill'){
        $data = Ill_Excuse::findOrfail($request->id);
        $attach= attachment::where('attachmentable_id',$request->id)->where('attachmentable_type','App\Ill_Excuse')->first();
        $name = Student::find($data->student_id);
        return response()->json(array('data'=>$data,'attach'=>$attach,'name'=>$name));
    }else if($request->type == 'Other'){
        $data = Excuse::findOrfail($request->id);
        $name = Student::find($data->student_id);
        $attach= attachment::where('attachmentable_id',$request->id)->where('attachmentable_type','App\Ill_Excuse')->first();
        return response()->json(array('data'=>$data, 'attach'=>$attach,'name'=>$name));
    }
    }
    public function update(Request $request)
    {
        if($request->type == 'Ill'){
            if($request->ajax())
        {/**update-student_id,update-title, update-description,
             update-start_date, update-end_date, update-doctor, update-hospital,
            update-address,update-money,update-status, update-attachment */
            $request->validate([
                'student_id' =>'required|string|max:50',
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'doctor' =>'string|required',
                'hospital' =>'string|required',
                'address' =>'string|required',
                'status' =>'string|required',
            ]);

            #image upload
            /*$file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);*/
            #end image upload
            $data = Ill_Excuse::findOrFail($request->id);
            $data->student_id = $request->student_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->money = $request->money;
            $data->doctor = $request->doctor;
            $data->hospital = $request->hospital;
            $data->address = $request->address;
            $data->status = $request->status;
            $data->save();
            #$data->attachments()->update(['path'=>$file_name]);
            $d = Student::find($request->student_id)->with('user')->get();
            $student = User::find($d->first()->user()->first()->id);
            $student_id = $request->student_id;
            $t = Auth::user();
            $dean = Dean::orderBy('id','DESC')->with('user')->get();
            $user = User::where('collage_id',Auth::user()->collage_id)->where('userable_type','App\Dean')->first();
            $dean_id = $user->userable_id;
            $excuse = Ill_Excuse::where('id',$request->id)->with('attachments')->first();
            $student->notify(new \App\Notifications\StudentExcusePaidNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date, $excuse->status));
            broadcast(new StudentExcusePaid($t,$excuse,$student_id));
            $user->notify(new \App\Notifications\DeanExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            broadcast(new DeanExcuse($t, $excuse, $dean_id));
            $respond['row'] = $data;
            return view('excuses/rowEdit')->with($respond);
        }
    }else if($request->type == 'Other'){
            if($request->ajax())
        {
            $request->validate([
                'student_id' =>'required|string|max:50',
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' =>'string|required',

            ]);
            #image upload
            /*$file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);*/
            #end image upload
            $data = Excuse::findOrFail($request->id);
            $data->student_id = $request->student_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->money = $request->money;
            $data->status = $request->status;
            $data->save();
            #$attach = $data->attachments()->update(['path'=>$file_name]);
            $d = Student::find($request->student_id)->with('user')->get();
            $student = User::find($d->first()->user()->first()->id);
            $student_id = $request->student_id;
            $t = Auth::user();
            $dean = Dean::orderBy('id','DESC')->with('user')->get();
            $user = User::where('collage_id',Auth::user()->collage_id)->where('userable_type','App\Dean')->first();
            $dean_id = $user->userable_id;
            $excuse = Excuse::where('id',$request->id)->with('attachments')->first();
            $student->notify(new \App\Notifications\StudentExcusePaidNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date, $excuse->status));
            broadcast(new StudentExcusePaid($t,$excuse,$student_id));
            $user->notify(new \App\Notifications\DeanExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            broadcast(new DeanExcuse($t, $excuse, $dean_id));
            $respond['row'] = $data;
            return view('excuses/rowEdit')->with($respond);
        }
    }
    }
    public function student_store(Request $request)
    {   $t = User::findOrFail(auth::id());
        $date1 = strtotime($request->start_date);
        $date2 = strtotime($request->end_date);
        $days=($date2-$date1)/86400;

        if($request->type == 'Ill' ){
            if($request->ajax())
        {
            $request->validate([
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'doctor' =>'string|required',
                'hospital' =>'string|required',
                'address' =>'string|required',
                'attachment' =>'required|image',
            ]);
            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = new Ill_Excuse;
            $data->student_id = $t->userable_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->doctor = $request->doctor;
            $data->hospital = $request->hospital;
            $data->address = $request->address;
            $data->status = 'Not paid';
            $data->save();
            $data->attachments()->create(['path'=>$file_name]);
            $d = Admin::orderBy('id','DESC')->with('user')->get();
            $user = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Admin')->get();
            //$admin_id = $d->first()->user()->where('collage_id',$t->collage_id)->first()->userable_id;
            $excuse = Ill_Excuse::orderBy('created_at','DESC')->where('student_id',$t->userable_id)->with('attachments')->first();
            Notification::send($user, new \App\Notifications\AdminExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            //$user->notify(new \App\Notifications\AdminExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            $i=0;$user_id = [];
            foreach ($user as $u) {
                $user_id[$i] = $u->userable_id;
                $i++;
            }
            broadcast(new AdminExcuse($t,$excuse,$user_id));
            $respond['row'] = $data;
            return view('excuses/ill_row')->with($respond);
        }
    }else if($request->type == 'Other'){
            if($request->ajax())
        {
            $request->validate([
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' =>'string',
                'attachment' =>'required|image',
            ]);
            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = new Excuse;
            $data->student_id = $t->userable_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 'Not Paid';
            $data->save();
            $attach = $data->attachments()->create(['path'=>$file_name]);
            $d = Admin::orderBy('id','DESC')->with('user')->get();
            $user = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Admin')->get();
            //$admin_id = $d->first()->user()->where('collage_id',$t->collage_id)->first()->userable_id;
            $excuse = Excuse::orderBy('created_at','DESC')->where('student_id',$t->userable_id)->with('attachments')->first();
            Notification::send($user, new \App\Notifications\AdminExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            //$user->notify(new \App\Notifications\AdminExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
            $i=0;$user_id = [];
            foreach ($user as $u) {
                $user_id[$i] = $u->userable_id;
                $i++;
            }
            broadcast(new AdminExcuse($t,$excuse,$user_id));
            $respond['row'] = $data;
            return view('excuses/row')->with($respond);
        }
    }
    }
    public function student_update(Request $request)
    {   $t = User::findOrFail(auth::id());
        if($request->type == 'Ill'){
            if($request->ajax())
        {
            $request->validate([
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'doctor' =>'string|required',
                'hospital' =>'string|required',
                'address' =>'string|required',
                'attachment' =>'required|image',
            ]);

            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = Ill_Excuse::findOrFail($request->id);

                $data->student_id = $t->userable_id;
                $data->title = $request->title;
                $data->description = $request->description;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->doctor = $request->doctor;
                $data->hospital = $request->hospital;
                $data->address = $request->address;
                $data->save();
                $data->attachments()->update(['path'=>$file_name]);
                $respond['row'] = $data;
                return view('excuses/rowEdit')->with($respond);

        }
    }else if($request->type == 'Other'){
            if($request->ajax())
        {
            $request->validate([
                'title' =>'string|required',
                'description' =>'string|required',
                'start_date' =>'required|date',
                'end_date' => 'required|date|after:start_date',
                'attachment' =>'required|image',
            ]);
            #image upload
            $file_extention = $request->attachment->getClientoriginalExtension();
            $file_name = time().'.'.$file_extention;
            $path = 'images/excuse';
            $request->attachment->move($path, $file_name);
            #end image upload
            $data = Excuse::findOrFail($request->id);

                $data->student_id = $t->userable_id;
                $data->title = $request->title;
                $data->description = $request->description;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->save();
                $attach = $data->attachments()->update(['path'=>$file_name]);
                $respond['row'] = $data;
                return view('excuses/rowEdit')->with($respond);

        }
    }
    }
    public function broadcast_to_dean()
    {   $t = User::findOrFail(auth::id());
        $d = Dean::orderBy('id','DESC')->with('user')->get();
        $user = User::find($d->first()->user()->where('collage_id',$t->collage_id)->first()->id);
        $dean_id = $d->first()->user()->where('collage_id',$t->collage_id)->first()->userable_id;
        $excuse = Ill_Excuse::orderBy('created_at','DESC')->where('student_id',$t->userable_id)->with('attachments')->first();
        //($excuse->attachments()->first()->path);
        $user->notify(new \App\Notifications\DeanExcuseNotification($t->email, $excuse->title, $excuse->attachments()->first()->path, $excuse->start_date));
        broadcast(new DeanExcuse($t,$excuse,$dean_id));
        return response()->json(array('user'=>$t, 'dean_id'=>$dean_id,'excuse'=>$excuse));
    }
    public function dean_update(Request $request)
    {
        if($request->type == 'Ill'){
            $data = Ill_Excuse::findOrFail($request->id);
            $start = $data->start_date;
            $end = $data->end_date;
            if($request->ajax())
        {
            $request->validate([
                'start_date' =>'required|date|before:'.$end.'|after_or_equal:'.$start,
                'end_date' => 'required|date|after:start_date|before_or_equal:'.$end,
            ]);

            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->save();

            $respond['row'] = $data;
            return response()->json(['row'=>$data]);
        }
    }else if($request->type == 'Other'){
            $data = Excuse::findOrFail($request->id);
            $start = $data->start_date;
            $end = $data->end_date;
            if($request->ajax())
        {
            $request->validate([
                'start_date' =>'required|date|before:'.$end.'|after_or_equal:'.$start,
                'end_date' => 'required|date|after:start_date|before_or_equal:'.$end,
            ]);
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->save();
            $respond['row'] = $data;
            return response()->json(['row'=>$data]);;
        }
    }
    }
    public function dean_excuse_accept(Request $request)
    {
        if($request->type == 'Other'){
            $update = Excuse::where('id',$request->id)->with('attachments')->first();
            $update->status = $request->status;
            $update->save();
            if($request->status == 'Completed'){
                Attendance::where('created_at','>=',$update->start_date)->where('created_at','<=',$update->end_date)->where('student_id',$update->student_id)->update(['attendanceable_id'=>$update->id,'attendanceable_type'=>'App\Excuse']);
            }
            $student = Student::find($update->student_id)->with('user')->first();
            $user = Auth::user();
            $recever = User::find($student->user()->first()->id);
            $recever->notify(new \App\Notifications\StudentExcuseAcceptedNotification($user->email, $update->title, $update->attachments()->first()->path, $update->start_date, $update->status));
            broadcast(new StudentExcuseAccepted($user, $update, $update->student_id));

            $user = Auth::user();
            $students = Student::orderBy('id','DESC')->with('user')->get();
            $ar = [];$i=0;
            foreach ($students as $st) {
            $ar[$i] = $st->user()->where('collage_id',$user->collage_id)->first()->userable_id;
            $i++;
            }
            $data['rows'] = Excuse::orderBy('id','DESC')->whereIn('student_id',$ar)->get();
            $data['rows2'] = Ill_Excuse::orderBy('id','DESC')->whereIn('student_id',$ar)->get();
            return view('dean/excuses')->with($data);

        }elseif($request->type == 'Ill'){
            $update = Ill_Excuse::where('id',$request->id)->with('attachments')->first();
            $update->status = $request->status;
            $update->save();
            if($request->status == 'Completed'){
                Attendance::where('created_at','>=',$update->start_date)->where('created_at','<=',$update->end_date)->where('student_id',$update->student_id)->update(['attendanceable_id'=>$update->id,'attendanceable_type'=>'App\Ill_Excuse']);
            }
            $user = Auth::user();
            $student = Student::find($update->student_id)->with('user')->first();
            $recever = User::find($student->user()->first()->id);
            $recever->notify(new \App\Notifications\StudentExcuseAcceptedNotification($user->email, $update->title, $update->attachments()->first()->path, $update->start_date, $update->status));
            broadcast(new StudentExcuseAccepted($user, $update, $update->student_id));
            $students = User::where('collage_id',auth::user()->collage_id)->where('userable_type','App\Student')->get();
            $ar = [];$i = 0;
            foreach ($students as $student) {
                $ar[$i] = $student->userable_id;
                $i++;
            }
            $data['rows'] = Excuse::orderBy('id','DESC')->whereIn('student_id',$ar)->get();
            $data['rows2'] = Ill_Excuse::orderBy('id','DESC')->whereIn('student_id',$ar)->get();
            return view('dean/excuses')->with($data);

        }

    }

}
