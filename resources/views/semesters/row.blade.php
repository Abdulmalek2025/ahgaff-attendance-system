<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->start_date}}</td>
    <td>{{$row->end_date}}</td>
    <td>
        <a  class="semester-edit" data-toggle="modal" data-route="{{url('/semesters/edit/'.$row->id)}}" data-target="#edit-semester-model"><i class="bx bx-edit edit-color"></i></a>
        <!--<a  class="semester-delete" data-toggle="modal" data-route="{{url('/semesters/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>-->
    </td>
</tr>
