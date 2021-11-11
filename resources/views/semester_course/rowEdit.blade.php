<td>{{$row->id}}</td>
<td>{{$row->group_id}}</td>
<td>{{$row->course_id}}</td>
<td>{{$row->teacher_id}}</td>
<td>
    <a  class="semester-co-edit" data-toggle="modal" data-route="{{url('/semester-course/edit/'.$row->id)}}" data-target="#edit-semester-course-modal"><i class="bx bx-edit edit-color"></i></a>
    <a  class="semester-co-delete" data-toggle="modal" data-route="{{url('/semester-course/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
</td>
