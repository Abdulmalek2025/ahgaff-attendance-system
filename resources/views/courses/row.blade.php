<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->description}}</td>
    <td>{{$row->credit}}</td>
    <td>
        <a  class="course-edit" data-toggle="modal" data-route="{{url('/courses/edit/'.$row->id)}}" data-target="#edit-course-modal"><i class="bx bx-edit edit-color"></i></a>
        <a  class="course-delete" data-toggle="modal" data-route="{{url('/courses/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
    </td>
</tr>
