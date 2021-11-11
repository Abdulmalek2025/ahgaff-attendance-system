<h2>Confirm Teacher</h2>
<div class="container-fluid">
        <div class="row">
            <form id="update-attendance-confirm" class="w-100">
                <div class="col-sm-12 mb-3">
                    <div class="d-flex justify-content-between pt-2">
                        <div>
                            <button type="submit" name="submit" class="btn btn-green mb-3">Confirm Attendance</button>
                        </div>
                        <div class="alert p-2 rounded bg-white" style="border: 1px rgb(54 138 101) solid;">{{$number}} Students</div>
                    </div>
                    <div class="">
                    <label>Semester Course</label>
                    <select name="sem_co" id="sem_co" class="form-control p-2">
                       <option value="{{$sem_co->id}}">{{$sem_co->course->name}} | {{$sem_co->group->name}} | {{$sem_co->semester->name}}</option>
                    </select>
                    <span class="sem_co text-danger"></span>
                    </div>
                    <div class="">
                    <label>Lctures</label>
                    <select name="lec" id="lec" class="form-control p-2">
                            <option value="{{$lec->id}}">{{$lec->created_at}}</option>
                    </select>
                    <span class="lec text-danger"></span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col"><input type="checkbox" name="all" id="all"/></th>
                            </tr>
                        </thead>
                        <tbody class="cont-data">
                        @foreach ($att as $at)
                            <tr>
                                <td id="{{$at->student->id}}">{{$at->student->id}}</td>
                                <td>{{$at->student->name}}</td>
                                @if ($at->is_present == 1)
                                <td><input type="checkbox" class="control-input" name="status[]" checked value={{$at->student->student_id}} /></td>

                                @else
                                    <td><input type="checkbox" class="control-input" name="status[]" value={{$at->student->student_id}} /></td>

                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
        $("#update-attendance-confirm").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-attendance-confirm')[0]);
            $.ajax({
                url: "{{url('/teacher/update-confirm')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    alert('Attendance Confirmed successfully!')
                    window.location.href = "http://127.0.0.1:8000/home"
                },
                error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        });
        /*$(document).on("change", "#sem_co", function () {
            const id = $("#sem_co").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/teacher/filter-lecture')}}",
                datatype: "JSON",
                success: function (data) {
                     $('#lec').html('')
                    if(data.lec.length>0){
                        for(var j=0; j<data.lec.length; j++){
                            $('#lec').append('<option value='+data.lec[j].id+'>'+data.lec[j].created_at+'</option>')
                        }
                    }
                    $('.cont-data').html('')
                    if(data.att.length>0){
                        for(var j=0; j<data.att.length; j++){
                            if(data.att[j].is_present == 1){
                                $(".cont-data").append('<tr id="'+data.att[j].student.id+'"><td class="pl-2">'+data.att[j].student.id+'</td><td>'+data.att[j].student.name+'</td><td><input type="checkbox" class="control-input" name="status[]" checked value='+data.att[j].student.student_id+' /></td></tr>')
                            }else{
                                 $(".cont-data").append('<tr id="'+data.att[j].student.id+'"><td class="pl-2">'+data.att[j].student.id+'</td><td>'+data.att[j].student.name+'</td><td><input type="checkbox" class="control-input" name="status[]" value='+data.att[j].student.student_id+' /></td></tr>')
                            }
                        }
                    }
                }
            })
        })*/
        /*change lec to set attendance*/
        $(document).on("change", "#lec", function () {
            const id = $("#lec").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/teacher/filter-attendance')}}",
                datatype: "JSON",
                success: function (data) {
                     $('.cont-data').html('')
                    if(data.att.length>0){
                        for(var j=0; j<data.att.length; j++){
                            if(data.att[j].is_present == 1){
                                $(".cont-data").append('<tr id="'+data.att[j].student.id+'"><td class="pl-2">'+data.att[j].student.id+'</td><td>'+data.att[j].student.name+'</td><td><input type="checkbox" class="control-input" name="status[]" checked value='+data.att[j].student.student_id+' /></td></tr>')
                            }else{
                                $(".cont-data").append('<tr id="'+data.att[j].student.id+'"><td class="pl-2">'+data.att[j].student.id+'</td><td>'+data.att[j].student.name+'</td><td><input type="checkbox" class="control-input" name="status[]" value='+data.att[j].student.student_id+' /></td></tr>')
                            }
                        }
                    }
                }
            })
        })
    </script>
