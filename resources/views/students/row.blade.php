<tr id="{{$row->id}}">
    <td>{{$row->student_id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$major}}</td>
    <td>{{$row->mobiles()->first()->mobile}}</td>
    <td>
        <a  class="edit-student" data-toggle="modal" data-route="{{url('/students/edit/'.$row->id)}}" data-target="#edit-student-modal"><i class="bx bx-edit edit-color"></i></a>
        <a  class="delete-student" data-toggle="modal" data-route="{{url('/students/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
    </td>
</tr>
