<td>{{'major'.$row->id}}</td>
<td>{{$row->name}}</td>
<td>{{$row->collage()->first()->name}}</td>
<td>
    <a  class="major-edit" data-toggle="modal" data-route="{{url('/major/edit/'.$row->id)}}" data-target="#edit-major-model"><i class="bx bx-edit edit-color"></i></a>
    <a  class="major-delete" data-toggle="modal" data-route="{{url('/major/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
</td>
