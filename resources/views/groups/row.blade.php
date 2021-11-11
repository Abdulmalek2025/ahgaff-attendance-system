<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->start_date}}</td>
    <td>{{$row->end_date}}</td>
    <td>
        <a  class="edit-student" data-toggle="modal" data-route="{{url('/groups/edit-student/'.$row->id)}}" data-target="#add-student-to-group-modal"><i class="bx bx-add-to-queue green-color"></i></a>
        <a  class="group-edit" data-toggle="modal" data-route="{{url('/groups/edit/'.$row->id)}}" data-target="#edit-group-modal"><i class="bx bx-edit edit-color"></i></a>
        <a  class="group-delete" data-toggle="modal" data-route="{{url('/groups/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
    </td>
</tr>
