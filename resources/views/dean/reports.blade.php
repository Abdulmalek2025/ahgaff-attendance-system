<h2>Reports</h2>
<div data-tabs class="tabs">
    <div class="d-flex justify-content-around m-auto bg-green rounded">
        <div><label for="tab-1" class="m-1 btn text-white">Semester</label></div>
        <div><label for="tab-2" class="m-1 btn text-white">Course</label></div>
        <div><label for="tab-3" class="m-1 btn text-white">Student</label></div>
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
                <h4 class="mt-3">Attendance report for a student</h4>
                <div>
                    <form id="admin-one-student">
                        <div class="form-group">
                            <label>Search</label>
                            <div class="input-group">
                                <input type="text" id="search" name="search" class="form-control typeahead" />
                                <div class="input-group-btn text-white bg-green rounded">
                                <button class="btn btn-default" type="submit">
                                    <i class="bx bxs-search text-white"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Presence</th>
                                    <th scope="col">Absence</th>
                                    <th scope="col">Ex-absence</th>
                                    <th scope="col">Lectures</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody class="admin-report-one-student-cont-data">

                            </tbody>
                        </table>
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
                    for(var i=0;i<data.semesters.length; i++){
                        $("#semester").append('<option value="'+data.semesters[i].id+'">'+data.semesters[i].name+'</option>')
                    }
                    for(var i=0;i<data.courses.length; i++){
                        $("#courses").append('<option value="'+data.courses[i].id+'">'+data.courses[i].name+'</option>')
                    }
                    for(var i=0;i<data.groups.length; i++){
                        $("#groups").append('<option value="'+data.groups[i].group.id+'">'+data.groups[i].group.name+'</option>')
                    }
                    for(var i = 0; i < data.sem_cos.length; i++){
                        $(".admin-report-semesters-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.sem_cos[i].course.name+'</td><td>'+data.sem_cos[i].teacher.name+'</td><td>'+data.sem_cos[i].group.name+'</td><td>'+data.lectures[i]+'</td></tr>')
                    }
                }
            })
        });
        /**/
        /*set table*/
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
                    for(var i = 0;i < data.result.length; i++){
                        $(".admin-report-course-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.result[i][0]+'</td><td>'+data.result[i][1]+'/'+data.result[i][4]+'</td><td>'+data.result[i][2]+'/'+data.result[i][4]+'</td><td>'+data.result[i][3]+'/'+data.result[i][4]+'</td></tr>')
                        }
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
         $("#admin-one-student").submit(function (e) {
            e.preventDefault();
            var search = $("#search").val();
            $.ajax({
                url: "{{url('admin/report/one-student-report')}}",
                type: "get",
                data: {'search':search},
                datatype: "JSON",
                success: function (dataBack) {
                    console.log(dataBack.result)
                    $(".admin-report-one-student-cont-data").html('');
                    for(var i = 0; i < dataBack.result.length; i++){
                        if(dataBack.result[i][5] == 'Pass'){
                            $(".admin-report-one-student-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td>'+dataBack.result[i][4]+'</td><td style="color:green">'+dataBack.result[i][5]+'</td></tr>')
                        }else{
                            $(".admin-report-one-student-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td>'+dataBack.result[i][4]+'</td><td style="color:red">'+dataBack.result[i][5]+'</td></tr>')
                        }

                    }
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        alert(item);
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
    </script>

