<h1 class="p-3">Attendance </h1>

    <div class="container-fluid">
        <div class="row">
            <form id="attendance_form" class="w-100">
                <div class="col-sm-12 mb-3">
                <a href="#" class="btn btn-green mb-3" id="back-to-report">Back</a>
                    <select class="form-control p-2 mb-3">
                        <option>{{$lec->sem_co()->first()->course()->first()->name}}</option>
                    </select>
                    <select class="form-control">
                        <option>{{$lec->created_at}}</option>
                    </select>
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
                        <tbody class="attendance-table">
                            @foreach ($atts as $student)
                                <tr>
                                    <td>{{$student->student_id}}</td>
                                    <td>{{$student->student->name}}</td>
                                    @if ($student->is_present == 1)
                                    <td><input type="checkbox" class="control-input" checked /></td>
                                    @elseif($student->is_present == 0 )
                                    <td><input type="checkbox" class="control-input"  /></td>
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
    $(document).on('click','#back-to-report',function(e){
        event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/reports",
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
    })
</script>
