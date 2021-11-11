<h3>Semester Courses</h3>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 mb-3">
                <button class="btn btn-green" id="open-add-modal" data-toggle="modal" data-target="#add-semester-course-modal"> Add New Semester Course
                </button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Group</th>
                            <th scope="col">Course</th>
                            <th scope="col">Teacher</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="cont-data">
                        @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td class="pl-2">{{$row->id}}</td>
                            <td>{{$row->group->name}}</td>
                            <td>{{$row->course->name}}</td>
                            <td>{{$row->teacher->name}}</td>
                            <td>
                                <a href="#" class="semester-co-edit" data-toggle="modal"
                                    data-route="{{url('/semester-course/edit/'.$row->id)}}" data-target="#edit-semester-course-modal"><i
                                        class="bx bx-edit edit-color"></i></a>
                                <a href="#" class="semester-co-delete" data-toggle="modal"
                                    data-route="{{url('/semester-course/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="add-semester-course-modal" tabindex="-1" role="dialog" aria-labelledby="add-semester-course-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-semester-course">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-semester-course-modalLabel">Add New Semester Course</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Group</label>
                            <select name="group" class="form-control" id="group">

                            </select>
                            <span class="group text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Course</label>
                            <select name="course" class="form-control" id="course">

                            </select>
                            <span class="course text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Teacher</label>
                            <select name="teacher" class="form-control" id="teacher">

                            </select>
                            <span class="teacher text-danger"></span>
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
    <div class="modal fade" id="edit-semester-course-modal" tabindex="-1" role="dialog" aria-labelledby="edit-semester-course-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit-semester-course">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-semester-course-modalLabel">Edit Semester Course</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="errorUpdate" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Group</label>
                            <input type="hidden" id="id" name="id" />
                            <select name="group" class="form-control" id="update-group">

                            </select>
                            <span class="group text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Course</label>
                            <select name="course" class="form-control" id="update-course">

                            </select>
                            <span class="course text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Teacher</label>
                            <select name="teacher" class="form-control" id="update-teacher">

                            </select>
                            <span class="teacher text-danger"></span>
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
    <script>
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //open add modal
        $(document).on("click", "#open-add-modal", function () {
            //var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: "/semester-course/openaddmodal",
                datatype: "JSON",
                success: function (data) {
                    $("#group").html("");
                    $("#course").html("");
                    $("#teacher").html("");
                    //console.log(data.groups[0].user[0].semester)
                    for(var i=0; i<data.groups.length; i++){
                        $("#group").append('<option value='+data.groups[i].id+'>'+data.groups[i].name+'</option>')
                    }
                    for(var i=0; i<data.courses.length; i++){
                        $("#course").append('<option value='+data.courses[i].id+'>'+data.courses[i].name+'</option>')
                    }
                    for(var i=0; i<data.teachers.length; i++){
                        $("#teacher").append('<option value='+data.teachers[i].id+'>'+data.teachers[i].name+'</option>')
                    }

                }
            })
        });
        //add one
        $("#add-semester-course").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-semester-course')[0]);
            $.ajax({
                url: "{{url('/semester-course/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $(".cont-data").prepend(dataBack)
                    $("#add-semester-course-modal").modal("hide");
                    $('div').removeClass('modal-backdrop')
                    /**/
                    $.ajax({
                        url:"/semester-course",
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
        $(document).on("click", ".semester-co-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for deleting?');
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
        $(document).on("click", ".semester-co-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#id").val(data.data.id);
                    $("#update-group").html("");
                    $("#update-course").html("");
                    $("#update-teacher").html("");
                    for(var i=0; i<data.groups.length; i++){
                        if(data.groups[i].id == data.data.group_id)
                        {
                            $("#update-group").append('<option value='+data.groups[i].id+' selected>'+data.groups[i].name+'</option>')
                        }else{
                            $("#update-group").append('<option value='+data.groups[i].id+'>'+data.groups[i].name+'</option>')
                        }
                    }
                    for(var i=0; i<data.courses.length; i++){
                        if(data.courses[i].id == data.data.course_id){
                            $("#update-course").append('<option value='+data.courses[i].id+' selected>'+data.courses[i].name+'</option>')
                        }else{
                            $("#update-course").append('<option value='+data.courses[i].id+'>'+data.courses[i].name+'</option>')
                        }

                    }
                    for(var i=0; i<data.teachers.length; i++){
                        if(data.teachers[i].id == data.data.teacher_id){
                            $("#update-teacher").append('<option value='+data.teachers[i].id+' selected>'+data.teachers[i].name+'</option>')
                        }else{
                            $("#update-teacher").append('<option value='+data.teachers[i].id+'>'+data.teachers[i].name+'</option>')
                        }
                    }
                }
            })
        })
        //update
        $("#edit-semester-course").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#edit-semester-course')[0]);
            var idRow = $("#id").val();
            $.ajax({
                url: "{{url('/semester-course/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $("#errorUpdate").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#" + idRow).html('')
                    $("#" + idRow).html(dataBack)
                    $('#edit-semester-course-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')

                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
    </script>
