<tr id="{{$row->id}}">
    <td>{{$row->id}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->addresses()->first()->city}}</td>
    <td>{{$row->mobiles()->first()->mobile}}</td>
    <td>
        <a href="#" class="edit-admin" data-toggle="modal" data-type="{{$row->user->type}}" data-userable-id="{{$row->user->userable_id}}" data-route="{{url('/admins/edit')}}" data-target="#edit-admin-modal"><i class="bx bx-edit edit-color"></i></a>
        <a  class="delete-admin" data-type="{{$row->user->type}}" data-type-userable-id="{{$row->user->userable_id}}" data-toggle="modal" data-route="{{url('/admins/delete')}}"><i class="bx bxs-trash delete-color"></i></a>
    </td>
</tr>
