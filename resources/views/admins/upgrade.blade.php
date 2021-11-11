<h2>Upgrade</h2>
<p class="text-danger">Note: you shold copy a database before make that...</p>
<div id="message" class="text-center">

</div>
<div>
    <form id="levelup">
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Semester</label>
                <select class="form-control" name="semester" id="semester">
                @foreach ($semesters as $semester)
                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Major</label>
                <select class="form-control" name="major" id="major">
                    <option value="0" selected>Select</option>
                @foreach ($majors as $major)
                    <option value="{{$major->id}}">{{$major->name}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </form>
</div>
<div class="mt-3 mb-5">
    <div class="row m-auto">
        <div class="col-sm-12">
        <form id="students-data">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col"><input type="checkbox" name="all" id="all"/></th>

                    </tr>
                </thead>
                <tbody class="student-cont">


                </tbody>
            </table>
            <input type="submit" value="Move" class="btn btn-green" />
        <form>
        </div>
    </div>
    <div class="mt-3 ml-2">
   <!-- <button id="copy-data" class="btn btn-warning">Copy DataBase</button> -->
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
    $("#students-data").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(jQuery('#students-data')[0]);
        $.ajax({
            url: "{{url('/admin/upgrade/levelup')}}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                    if(data.success){
                        $("#message").html('<span class="alert alert-success">'+data.success+'</span>')
                        setTimeout(function(){ $("#message").hide() }, 3000)
                    }
                    if(data.warning){
                        $("#message").html('<span class="alert alert-warning">'+data.warning+'</span>')
                        setTimeout(function(){ $("#message").hide() }, 3000)
                    }
                    if(data.error){
                        $("#message").html('<span class="alert alert-danger">'+data.error+'</span>')
                        setTimeout(function(){ $("#message").hide() }, 3000)
                    }
            }, error: function (xhr, status, error) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    $("."+key).html(item)
                })
            }
        })
    })
    $(document).on("change", "#major", function () {
        const major_id = $("#major").val();
        const semester_id = $("#semester").val();
        $.ajax({
            type: "get",
            data:{'semester_id':semester_id,'major_id':major_id},
            url: "{{url('/admin/upgrade/change/major')}}",
            datatype: "JSON",
            success: function (data) {
                $(".student-cont").html("")
                console.log(data.students)
                for(var i = 0;i < data.students.length;i++){
                    $(".student-cont").append('<tr><td id="'+data.students[i].student_id+'">'+data.students[i].student_id+'</td><td>'+data.students[i].name+'</td><td><input type="checkbox" class="control-input s" name="status[]" value="'+data.students[i].id+'" /></td><tr>')

                }
            }
        })
    })
    $("#copy-data").click(function(){
         $.ajax({
            type: "get",
            url: "{{url('/admin/upgrade/copy/data')}}",
            datatype: "JSON",
            success: function (data) {
                if(data.success){
                    $("#message").html('<span class="alert alert-success">'+data.success+'</span>')
                    setTimeout(function(){ $("#message").hide() }, 3000)
                }else{
                    $("#message").html('<span class="alert alert-denger">There are an error</span>')
                    setTimeout(function(){ $("#message").hide() }, 3000)
                }
            }
        })
    });
</script>
