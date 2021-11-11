<h1 class="p-3">Update Attendance<i class="bx bxs-user"></i> </h1>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
    <div class="container-fluid">
        <div class="row">
            <form id="attendance_form" class="w-100">
                <div class="col-sm-12 mb-3">
                    <button type="submit" name="submit" class="btn btn-green mb-3">Attend</button>
                    <div class="form-group">
                    <input type="hidden" name="group_id" id="group_id" />
                    <label>Semester courses</label>
                    <select name="group" id="group" class="form-control p-2 mb-3">
                        <option value="0">Select</option>
                        <!--on change sem_co-->
                    </select>
                    </div>
                    <div class="form-group">
                    <label>Lecture</label>
                    <select name="course" id="course" class="form-control">
                        <option value="0">Select</option>
                        <!--on change lecture-->
                    </select>
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
                        <tbody class="cont-data-att">

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
        $(document).ready(function(){
            $.ajax({
                type: "get",
                url: "{{url('/attendance/set-group')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".cont-data-att").html("");
                    console.log(data.group)
                    $("#group_id").val(data.group.id);
                    $("#group").html('<option value="0">Select</option>')//semester course
                    for(var i=0; i<data.sem.length;i++){
                        $("#group").append('<option value='+data.sem[i].id+'>'+data.sem[i].course.name +' | '+ data.sem[i].teacher.name +' | '+data.sem[i].group.name+' | '+data.sem[i].semester.name+'</option>')
                    }
                    $("#course").html('<option value="0">Select</option>')//lectures
                }
            })
        });
        $(document).on("change", "#group", function () {
            const id = $("#group").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/attendance/filter')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".cont-data-att").html('')
                    $("#group_id").val(data.sem_co.group_id);
                    $("#course").html('<option value="0">Select</option>')
                    for(var i=0; i<data.lectures.length; i++){
                        $("#course").append('<option value='+data.lectures[i].id+'>'+data.lectures[i].created_at+'</option>')
                    }
                }
            })
        })
        $(document).on("change", "#course", function () {
            const id = $("#course").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/attendance/filter-lecture')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".cont-data-att").html('')
                    if(data.attendance.length>0){
                        for(var i=0; i<data.attendance.length; i++){
                            console.log(data.attendance[i].student.name)
                            $(".cont-data-att").append('<tr><td>'+data.attendance[i].student_id+'</td><td>'+data.attendance[i].student.name+'</td><td><input type="checkbox" name="status[]" value="'+data.attendance[i].student_id+'"/></td></tr>')
                        }
                        for(var j=0; j<data.attendance.length; j++){
                            if(data.attendance[j].is_present){
                                console.log(data.attendance[j].student_id)
                                $('input[value='+data.attendance[j].student_id+']').prop('checked',true)
                            }
                        }
                    }else{
                        $("input[type=checkbox]").prop('checked', false);
                    }
                }
            })
        })
        $("#all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
        $("#attendance_form").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#attendance_form')[0]);
            console.log(formData)
            $.ajax({
                url: "{{url('/attendance/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    alert('Attendance Updated successfully')

                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {

                        $("#errorUpdate").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            });
        })

    </script>
