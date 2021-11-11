<h2>Reports</h2>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div data-tabs class="tabs">
    <div class="d-flex justify-content-around m-auto bg-green rounded">
        <div><label for="tab-1" class="m-1 btn text-white">Semester</label></div>
        <div><label for="tab-2" class="m-1 btn text-white">Course</label></div>
        <div><label for="tab-3" class="m-1 btn text-white">Student</label></div>
        <div><label for="tab-4" class="m-1 btn text-white">All couurses</label></div>
    </div>
    <div class="success text-center hide" id="message">
                    <span class="alert alert-success" id="mes">Your message was recieved</span>
                </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-1" checked>
            <label for="tab-1" class="d-none">Semester</label>
            <div class="tab__content">
                <h4 class="mt-3">All Semesters</h4>
                <div class="">
                    <form id="sem_co_form">
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" id="semester">

                            </select>
                        </div>
                    </form>
                    <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Lectures</th>
                                </tr>
                            </thead>
                            <tbody class="admin-report-semesters-cont-data">

                            </tbody>
                        </table>
                        <div class="text-center total text-white bg-green rounded"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-2">
            <label for="tab-2" class="d-none">Courses</label>
            <div class="tab__content">
                <h4 class="mt-3">Courses</h4>
                <div>
                    <form id="students">
                        <div class="form-group">
                            <label>Courses</label>
                            <select name="courses" id="courses" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Groups</label>
                            <select name="groups" id="groups" class="form-control">

                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">Presence</th>
                                    <th scope="col">Absence</th>
                                    <th scope="col">Ex-absence</th>
                                </tr>
                            </thead>
                            <tbody class="admin-report-course-cont-data">

                            </tbody>
                        </table>
                        <div class="text-center total text-white bg-green rounded"></div>
                </div>
            </div>
        </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-3">
            <label for="tab-3" class="d-none">Student</label>
            <div class="tab__content">

                <div>
                    <form id="admin-one-student">
                        <div class="form-group">
                            <label class="my-3">Search</label>
                            <div class="input-group">
                                <input type="text" id="search" name="search" class="form-control typeahead" />
                                <div class="input-group-btn text-white bg-green rounded">
                                <button class="btn btn-default" type="submit">
                                    <i class="bx bxs-search text-white"></i>
                                </button>
                                </div>
                            </div>
                            <span class="search text-danger"></span>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                        <table class="table table-striped table-hover" id="table-content">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Presence</th>
                                    <th scope="col">Absence</th>
                                    <th scope="col">Ex-absence</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody class="admin-report-one-student-cont-data">

                            </tbody>
                        </table>
                </div>
                <div>
                    <form id="mail_form">
                        <input type="mail" disabled class="form-control mt-3" name="mail" id="mail" />
                        <span class="mail text-danger"></span>
                        <input type="text" name="subject" id="subject" class="form-control mt-3" placeholder="Subject"/>
                        <span class="subject text-danger"></span>
                        <textarea class="form-control mt-3" id="body" name="body" placeholder="Body" ></textarea>
                        <span class="body text-danger"></span><br>
                        <input type="submit" class="btn btn-info text-white mt-3 mb-3" style="position:relative;left:90%"  value="Email" />
                        <button class="btn btn-danger" id="reset">Reset</button>
                        <button class="btn btn-warning" id="backup">Backup</button>
                        <button class="btn btn-success" id="restore">Restore</button>
                    </form>
                    <form>
                        <input type="file" class="form-control w-25 mt-3" name="database_path" id="db-path"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-4">
            <label for="tab-4" class="d-none">Student</label>
            <div class="tab__content">
            <div class="mt-3">
                <h4>All Courses</h4>
                <form>
                    <div class="form-group">
                        <label>Collages</label>
                        <select class="form-control" id="major-4" name="major_4">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select class="form-control" id="semester-4" name="semester_4">
                            <option value="0">Select</option>
                        </select>
                    </div>
                </form>
                <div class="col-sm-12">
                        <table class="table table-striped table-hover" id="table-4-content">
                            <thead>
                                <tr id="rows-4">


                                </tr>
                            </thead>
                            <tbody class="admin-tab-4-cont-data">

                            </tbody>
                        </table>
                </div>

            </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/bootstrap3-typeahead.min.js')}}"></script>
    <script>

        (function ($, document) {

            // get tallest tab__content element
            let height = -1;

            $('.tab__content').each(function () {
                height = height > $(this).outerHeight() ? height : $(this).outerHeight();
                $(this).css('position', 'absolute');
            });

            // set height of tabs + top offset
            $('[data-tabs]').css('min-height', height + 40 + 'px');

        }(jQuery, document));
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /**/

        $(document).ready(function(){
            $.ajax({
                type: "get",
                url: "{{url('/report/admin_setup')}}",
                datatype: "JSON",
                success: function (data) {
                    $("#semester").html('')
                    $(".admin-report-semesters-cont-data").html('')
                    console.log(data.groups)
                    $("#semester").html('<option value="0">Select</option>')
                    for(var i=0;i<data.semesters.length; i++){
                        $("#semester").append('<option value="'+data.semesters[i].id+'">'+data.semesters[i].name+'</option>')
                        $("#semester-4").append('<option value="'+data.semesters[i].id+'">'+data.semesters[i].name+'</option>')
                    }
                    $("#courses").html('<option value="0">Select</option>')
                    for(var i=0;i<data.courses.length; i++){
                        $("#courses").append('<option value="'+data.courses[i].id+'">'+data.courses[i].name+'</option>')
                    }
                    $("#groups").html('<option value="0">Select</option>')
                    for(var i=0;i<data.groups.length; i++){
                        $("#groups").append('<option value="'+data.groups[i].group.id+'">'+data.groups[i].group.name+'</option>')
                    }
                    for(var i = 0;i< data.majors.length;i++){
                        $("#major-4").append('<option value="'+data.majors[i].id+'">'+data.majors[i].name+'</option>')
                    }
                    /*for(var i = 0; i < data.sem_cos.length; i++){
                        $(".admin-report-semesters-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.sem_cos[i].course.name+'</td><td>'+data.sem_cos[i].teacher.name+'</td><td>'+data.sem_cos[i].group.name+'</td><td>'+data.lectures[i]+'</td></tr>')
                    }*/
                }
            })
        });
        /**/
        /*set table*/
        $(document).on('change','#semester-4',function(){
            let major = $("#major-4").val()
            let semester = $("#semester-4").val()
            $.ajax({
                type:'get',
                data:{'major':major, 'semester':semester},
                url:"{{url('admin/report/tab-4')}}",
                datatype:'JSON',
                success: function(data){
                    $(".admin-tab-4-cont-data").html('')
                    console.log(data.persons[2].course)
                    $("#rows-4").html('<th scope="col">No.</th><th scope="col">Name</th>')
                    for(let i = 0;i< data.persons[0].course.length; i++){
                        $("#rows-4").append("<th scope='col'>"+data.persons[1].course[i][0]+"</th>")
                    }
                    //let course = data.persons[0].course[0][0];
                    for(let i = 0;i < data.persons.length; i++){
                        $(".admin-tab-4-cont-data").append('<tr id="row-'+i+'"><td>'+(i+1)+'</td><td>'+data.persons[i].name+'</td></tr>')
                        for(let j = 0;j<data.persons[i].course.length;j++){
                            //if(course != data.persons[i].course[j][0]){
                                if(data.persons[i].course[j][1] == "Success"){
                                $("#row-"+i).append('<td style="color:green">'+data.persons[i].course[j][1]+'</td>')
                            }else{
                                $("#row-"+i).append('<td style="color:red">'+data.persons[i].course[j][1]+'</td>')
                            }
                           // course = data.persons[i].course[j][0];
                            //}
                        }
                    }
                    //.admin-tab-4-cont-data,#rows-4
                }
            })
        });
        $(document).on("change", "#semester", function () {
            const id = $(this).val();
            console.log(id)
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('admin/report/semester_report')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".admin-report-semesters-cont-data").html('')
                    for(var i = 0;i < data.sem_cos.length; i++){
                        $(".admin-report-semesters-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.sem_cos[i].course.name+'</td><td>'+data.sem_cos[i].teacher.name+'</td><td>'+data.sem_cos[i].group.name+'</td><td>'+data.lectures[i]+'</td></tr>')
                        }
                    }
                }
            )
        })
        /**/
        $(document).on("click", "#tab-2", function () {
            $.ajax({
                type: "get",
                url: "{{url('admin/report/course_report')}}",
                datatype: "JSON",
                success: function (data) {
                    console.log(data.result)
                    $(".admin-report-course-cont-data").html('')
                    /*for(var i = 0;i < data.result.length; i++){
                        $(".admin-report-course-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.result[i][0]+'</td><td>'+data.result[i][1]+'/'+data.result[i][4]+'</td><td>'+data.result[i][2]+'/'+data.result[i][4]+'</td><td>'+data.result[i][3]+'/'+data.result[i][4]+'</td></tr>')
                        }*/
                    }
                }
            )
        })
        /**/
        $(document).on("change", "#courses", function () {
            const id = $(this).val();
            console.log(id)
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('admin/report/change_course')}}",
                datatype: "JSON",
                success: function (data) {
                        $("#groups").html('')
                        $("#groups").html('<option value="0">none</option>')
                        for(var i = 0; i<data.groups.length;i++){
                            $("#groups").append('<option value="'+data.groups[i].group.id+'">'+data.groups[i].group.name+'</option>')
                        }
                    }
                }
            )
        })
        /**/
        $(document).on("change", "#groups", function () {
            const group_id = $(this).val();
            const course_id = $("#courses").val();
            $.ajax({
                type: "get",
                data:{'group_id':group_id,'course_id':course_id},
                url: "{{url('admin/report/change_groups')}}",
                datatype: "JSON",
                success: function (data) {
                        $(".admin-report-course-cont-data").html('')
                        for(var i = 0;i < data.result.length; i++){
                            $(".admin-report-course-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.result[i][0]+'</td><td>'+data.result[i][1]+'/'+data.result[i][4]+'</td><td>'+data.result[i][2]+'/'+data.result[i][4]+'</td><td>'+data.result[i][3]+'/'+data.result[i][4]+'</td></tr>')
                            }

                    }
                }
            )
        })
        /**/
            //$course_name,$presence, $absence, $ex_absence, $lec_num,$status
         $("#admin-one-student").submit(function (e) {
            e.preventDefault();
            var search = $("#search").val();
            $.ajax({
                url: "{{url('admin/report/one-student-report')}}",
                type: "get",
                data: {'search':search},
                datatype: "JSON",
                success: function (dataBack) {
                    $("#mail").val(dataBack.mail)
                    $(".admin-report-one-student-cont-data").html('');
                    for(var i = 0; i < dataBack.result.length; i++){
                        if(dataBack.result[i][5] == 'Success'){
                            $(".admin-report-one-student-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td style="color:green">'+dataBack.result[i][5]+'</td></tr>')
                        }else if(dataBack.result[i][5] == 'Forbidden'){
                            $(".admin-report-one-student-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td style="color:yellow">'+dataBack.result[i][5]+'</td></tr>')
                        }else{
                            $(".admin-report-one-student-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td style="color:red">'+dataBack.result[i][5]+'</td></tr>')
                        }

                    }
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        });
        /**/
        $("#mail_form").submit(function (e) {
            e.preventDefault();
            //var mailForm = new FormData(jQuery('#edit-excuse')[0]);
            const mail = $("#mail").val()
            const subject = $("#subject").val()
            const body = $("#body").val()
            const report = $("#table-content").html()
            $.ajax({
                url: "{{url('admin/report/mail')}}",
                type: "post",
                data: {'mail':mail,'subject':subject,'body':body,'report':report},
                datatype: "JSON",
                success: function (dataBack) {
                    $("#mes").html(dataBack.success)
                    $(".success").show()
                    setTimeout(function(){ $(".success").hide() }, 4000)
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        });
        /**/
        var path = "{{route('admin-tab-3-search')}}";
        $("input.typeahead").typeahead({
            source:function(terms,process){
                return $.get(path,{terms:terms},function(data){
                    return process(data);
                })
            }
        });
        $(".success").hide()
        $(document).on('click','#reset', function(){
            $.ajax({
                url: "{{url('admin/setting/reset')}}",
                type: "get",
                success: function (dataBack) {
                    console.log('ok')
                    $("#mes").html(dataBack.success);
                    $(".success").show()
                    setTimeout(function(){ $(".success").hide() }, 4000)
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {

                    })
                }
            })
        });
        /**/
        $(document).on('click','#backup', function(){
            $.ajax({
                url: "{{url('admin/setting/backup')}}",
                beforeSend:function(){
                    $("#mes").html('Backuping...')
                    $(".success").show()
                },
                complete:function(c){
                    $("#.success").hide(1000)
                },
                type: "get",
                success: function (dataBack) {
                    $("#mes").html(dataBack.success);
                    $(".success").show()
                    setTimeout(function(){ $(".success").hide() }, 4000)
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {

                    })
                }
            })
        });
        /**/
        $(document).on('click','#restore', function(){

            var test = document.getElementById('db-path');
            if(test.files.item(0)){
                var path = test.files.item(0).name;
                $.ajax({
                url: "{{url('admin/setting/restore')}}",
                beforeSend:function(){
                    $("#mes").html('Restoring...')
                    $(".success").show()
                },
                complete:function(c){
                    $("#.success").hide(1000)
                },
                type: "get",
                data:{ 'path':path},
                success: function (dataBack) {
                    console.log('ok')
                    $("#mes").html(dataBack.success);
                    $(".success").show()
                    setTimeout(function(){ $(".success").hide() }, 4000)
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {

                    })
                }
            })
            }

        });
    </script>

