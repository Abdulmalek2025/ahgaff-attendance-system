<td>{{$row->id}}</td>
<td>{{$row->name}}</td>
<td>{{$row->location}}</td>
<td>{{$row->telephone}}</td>
<td>
    <a  class="collage-edit" data-toggle="modal" data-route="{{url('/collage/edit/'.$row->id)}}" data-target="#edit-collage-model"><i class="bx bx-edit edit-color"></i></a>
    <!--<a  class="collage-delete" data-toggle="modal" data-route="{{url('/collage/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>-->
</td>
