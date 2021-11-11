@foreach($rows as $row)
<tr id="{{$row->id}}">
    <td class="pl-2">{{$row->name}}</td>
    <td>{{$row->name}}</td>
    <td>{{$row->name}}</td>
    <td><input type="checkbox" class="control-input" name="status[]" value="{{ $row->student_id }}" />
    </td>
</tr>
@endforeach
