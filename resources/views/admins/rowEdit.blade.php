<td>{{$row->id}}</td>
<td>{{$row->name}}</td>
<td>{{$row->addresses()->first()->city}}</td>
<td>{{$row->mobiles()->first()->mobile}}</td>
<td>
    <a  class="edit" data-toggle="modal" data-type="{{$row->user->type}}" data-type-userable-id="{{$row->user->userable_id}}" data-route="{{url('/admins/edit')}}" data-target="#edit-admin-modal"><i class="bx bx-edit edit-color"></i></a>
    <a  class="delete" data-toggle="modal" data-type="{{$row->user->type}}" data-type-userable-id="{{$row->user->userable_id}}" data-route="{{url('/admins/delete')}}"><i class="bx bxs-trash delete-color"></i></a>
</td>
