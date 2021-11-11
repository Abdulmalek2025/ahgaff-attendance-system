<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->student_id}}</td>
    <td>{{$row->title}}</td>
    <td>{{$row->start_date}}</td>
    <td>{{$row->status}}</td>
    <td>
        <a  class="excuse-edit" data-toggle="modal" id-type="{{$row->id}}" type-edit="Ill" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a>
        <!--<a  class="excuse-delete" data-toggle="modal" id-type="{{$row->id}}" type-edit="Ill" data-route="{{url('/excuses/delete')}}"><i class="bx bxs-trash delete-color"></i></a>-->
    </td>
</tr>
