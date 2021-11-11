<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->addresses()->first()->city}}</td>
    <td>{{$row->mobiles()->first()->mobile}}</td>
    <td>
        <a  class="edit-teacher" data-toggle="modal" data-route="{{url('/teachers/edit/'.$row->id)}}" data-target="#edit-teacher-modal"><i class="bx bx-edit edit-color"></i></a>
        <a  class="delete-teacher" data-toggle="modal" data-route="{{url('/teachers/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
    </td>
</tr>
