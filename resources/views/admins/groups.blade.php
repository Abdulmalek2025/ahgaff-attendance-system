<h1 class="p-3">All Groups! <i class="bx bxs-user"></i> </h1>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 mb-3">
                <button class="btn btn-green" data-toggle="modal" data-target="#add-group-modal"> Add New Group </button>
                <i class="fa fa-refresh"></i>

            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col" style="min-width:129px">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="group-cont-data">
                    @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td class="pl-2">{{$row->id}}</td>
                            <td style="min-width:200px;">{{$row->name}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->end_date}}</td>

                            <td>
                                <a href="#" class="edit-student-group" data-toggle="modal" data-route="{{url('/groups/edit-student/'.$row->id)}}" data-target="#add-student-to-group-modal"><i class="bx bx-add-to-queue green-color"></i></a>
                                <a href="#" class="group-edit" data-toggle="modal" data-route="{{url('/groups/edit/'.$row->id)}}" data-target="#edit-group-modal"><i class="bx bx-edit edit-color"></i></a>
                                <a href="#" class="group-delete" data-toggle="modal" data-route="{{url('/groups/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="add-group-modal" tabindex="-1" role="dialog" aria-labelledby="add-group-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-group">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-group-modalLabel">Add New Group</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <span class="name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                            <span class="start_date text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" autocomplete="city">
                            <span class="end_date text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--update Modal -->
    <div class="modal fade" id="edit-group-modal" tabindex="-1" role="dialog" aria-labelledby="edit-group-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="update-group">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-group-modalLabel">Edit Course</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="errorUpdate" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="edit_name" class="form-control">
                            <input type="hidden" id="id" name="edit_id">
                            <span class="edit_name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="edit_start_date" id="start_date" class="form-control" />
                            <span class="edit_start_date text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="edit_end_date" id="end_date" class="form-control" />
                            <span class="edit_end_date text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--add student to group-->
    <div class="modal fade" id="add-student-to-group-modal" tabindex="-1" role="dialog" aria-labelledby="add-group-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-student-to-group">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addModalLabel">Set Students</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="hidden" name="add_student_id" id="aid" class="form-control">
                            <input  disabled type="text" name="add_student_name" id="aname" class="form-control">
                            <span class="add_student_name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input disabled type="date" name="add_student_start_date" id="astart_date" class="form-control">
                            <span class="add_student_start_date text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input disabled type="date" name="add_student_end_date" id="aend_date" class="form-control" />
                            <span class="add_student_end_date text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" id="semester">
                                @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                                @endforeach
                            </select>
                            <span class="semester text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Major</label>
                            <select name="major" class="form-control" id="major">
                                <option value="0">Select</option>
                                @foreach ($majors as $major)
                                    <option value="{{$major->id}}">{{$major->name}}</option>
                                @endforeach
                            </select>
                            <span class="semester text-danger"></span>
                        </div>
                        <!--table student-->
                        <div class="row">
                            <div class="col-sm-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">City</th>
                                <th scope="col"><input type="checkbox" name="all" id="all"/></th>
                            </tr>
                        </thead>
                        <tbody class="group-cont-data-modal">

                        </tbody>
                    </table>
                </div>
                        </div>
                <!--end table-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#add-group").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-group')[0]);
            $.ajax({
                url: "{{url('/groups/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $(".group-cont-data").prepend(dataBack)
                    $('#add-group-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    $("#add-group")[0].reset();
                    /**/
                    $.ajax({
                        url:"/groups",
                        type:"get",
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
                    /**/
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        //delte
        $(document).on("click", ".group-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for deleting!');
            if(check){
                $.ajax({
                type: "get",
                url: route,
                success: function (data) {
                    alert(data.success);
                    $("#" + data.id).remove();
                }
            })
            }
        })
        //edit
        $(document).on("click", ".group-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $("#start_date").val(data.data.start_date);
                    $("#end_date").val(data.data.end_date);

                }
            })
        })
        //  update
        $("#update-group").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-group')[0]);
            var idRow = $("#id").val();
            $.ajax({
                url: "{{url('/groups/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $("#" + idRow).html('')
                    $("#" + idRow).html(dataBack)
                    $('#edit-group-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    $("#update-group")[0].reset();
                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        $(document).on("click", ".edit-student-group", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $('.group-cont-data-modal').html("");
                    console.log(data.data.start_date)
                    $("#aid").val(data.data.id);
                    $("#aname").val(data.data.name);
                    $("#astart_date").val(data.data.start_date);
                    $("#aend_date").val(data.data.end_date);
                    for(var i = 0; i < data.student.length; i++){
                        $('.group-cont-data-modal').append('<tr><td id="'+data.student[i].id+'">'+data.student[i].student_id+'</td><td>'+data.student[i].name+'</td><td>'+data.student[i].addresses[0].city+'</td><td><input type="checkbox" class="control-input" name="status[]" value="'+data.student[i].id+'" /></td><tr>');
                    }
                    if(data.state[0].user.length>0){
                        console.log(data.state[0].user[0].name);
                        for(var j=0; j<data.state[0].user.length; j++){
                        $("input[value='"+data.state[0].user[j].id+"']").prop('checked',true)
                        }
                    }else{
                        $("input[type=checkbox]").prop('checked', false);
                    }

                }
            })
        });
        //select semester
        $(document).on("change", "#major", function () {
            const major_id = $("#major").val();
            const semester_id = $("#semester").val();
            const group = $("#aid").val();
            $.ajax({
                type: "get",
                data:{'semester_id':semester_id,'major_id':major_id,'group':group},
                url: "{{url('/groups/filter')}}",
                datatype: "JSON",
                success: function (data) {
                    $('.group-cont-data-modal').html("");
                    for(var i = 0; i < data.student.length; i++){
                        $('.group-cont-data-modal').append('<tr><td id="'+data.student[i].student_id+'">'+data.student[i].student_id+'</td><td>'+data.student[i].name+'</td><td>'+data.student[i].addresses[0].city+'</td><td><input type="checkbox" class="control-input s" name="status[]" value="'+data.student[i].id+'" /></td><tr>');
                    }
                    for(var j=0; j<data.data.user.length; j++){
                        $("input[value='"+data.data.user[j].id+"']").prop('checked',true)
                    }

                }
            })
        })
        //  update
        $("#add-student-to-group").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-student-to-group')[0]);
            var idRow = $("#id").val();
            $.ajax({
                url: "{{url('/groups/update-student')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $('#add-student-to-group-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    /**/
                    $.ajax({
                        url:"/groups",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide()
                        },

                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    /**/

                }, error: function (xhr, status, error) {
                    //console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
    </script>
