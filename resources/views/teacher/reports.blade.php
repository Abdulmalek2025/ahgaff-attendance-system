<h2>Reports</h2>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div data-tabs class="tabs">
    <div class="d-flex justify-content-around m-auto bg-green rounded">
        <div><label for="tab-1" class="m-1 btn text-white">Semester</label></div>
        <div><label for="tab-2" class="m-1 btn text-white">Courses</label></div>
        <div><label for="tab-3" class="m-1 btn text-white">Student</label></div>
    </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-1" checked>
            <label for="tab-1" class="d-none">Semester</label>
            <div class="tab__content">
                <h4 class="mt-3">All Semester Courses</h4>
                <div class="">
                    <form id="sem_co_form">
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" id="semester">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="sem_co" class="form-control" id="sem_co">

                            </select>
                        </div>
                    </form>
                    <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Attendance Type</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="cont-data">

                            </tbody>
                        </table>
                        <div class="text-center total text-white bg-green rounded"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-2">
            <label for="tab-2" class="d-none">Students</label>
            <div class="tab__content">
                <h4 class="mt-3">Students</h4>
                <div>
                    <form id="students">
                        <div class="form-group">
                            <label>Semester Courses</label>
                            <select name="semser_courses" id="semser_courses" class="form-control">

                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Period</th>
                                </tr>
                            </thead>
                            <tbody class="course-cont-data">

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
                <h4 class="mt-3">Tab heading 3</h4>
                <div>
                    <form id="one-student">
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
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody class="tab-3-cont-data">

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
                url: "{{url('/report/teatcher_setup')}}",
                datatype: "JSON",
                success: function (data) {
                    $("#sem_co").html('')
                    $("#semester").html('')
                    $("#semester").html('<option value="0">Select</option>')
                    for(var i = 0;i < data.semesters.length; i++){
                        $("#semester").append('<option value="'+data.semesters[i].id+'">'+data.semesters[i].name+'</option>')
                    }
                    if(data.setupData.length > 0){
                        $("#sem_co").html('<option value="0">Select</option>')
                        for(var i = 0; i<data.setupData.length; i++){
                       $("#sem_co").append('<option value='+data.setupData[i].id+'>'+data.setupData[i].course.name+'</option>')
                    }
                }
                $(".cont-data").html('')
                    for(var i = 0; i< data.setupLec.length; i++){
                        //$(".cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.setupLec[i].created_at+'</td><td>'+data.setupLec[i].att_type+'</td><td>'+data.setupLec[i].period+'</td><td><a id="detail" href="#" lec-id="'+data.setupLec[i].id+'" lec-date="'+data.setupLec[i].created_at+'"><i class="bx bx-detail edit-color"></i></a></td></tr>')
                    }
                    //$(".total").html('<h4>Total Hours: '+data.setupTotal+'</h4>')
                }
            })
        });
        /**/
        $(document).on("change", "#semester", function () {
            const id = $("#semester").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/report/semester_course')}}",
                datatype: "JSON",
                success: function (data) {
                    $("#sem_co").html('')
                    if(data.data.length > 0){
                        $("#sem_co").append('<option value="0">Select</option>')
                        for(var i = 0; i<data.data.length; i++){
                       $("#sem_co").append('<option value='+data.data[i].id+'>'+data.data[i].course.name+'</option>')
                    }
                    }
                }
            })
        })
        /*set table*/
        $(document).on("change", "#sem_co", function () {
            const id = $("#sem_co").val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/report/semester_course_report')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".cont-data").html('')
                    for(var i = 0; i< data.lec.length; i++){
                        $(".cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.lec[i].created_at+'</td><td>'+data.lec[i].att_type+'</td><td>'+data.lec[i].period+'</td><td><a id="detail" href="#" lec-id="'+data.lec[i].id+'" lec-date="'+data.lec[i].created_at+'"><i class="bx bx-detail edit-color"></i></a></td></tr>')
                    }
                    $(".total").html('<h4>Total Hours: '+data.total+'</h4>')
                    }
                }
            )
        })
        /**/
        $(document).on("click", "#tab-2", function () {
            $.ajax({
                type: "get",
                url: "{{url('/report/course_report')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".course-cont-data").html('')
                    $("#semser_courses").html('')
                    $("#semser_courses").append('<option value="0">Select</option>')
                    for(var i = 0;i<data.sem_cos.length; i++){
                        $("#semser_courses").append('<option value="'+data.sem_cos[i].id+'">'+data.sem_cos[i].course.name+' | '+data.sem_cos[i].semester.name+' | '+data.sem_cos[i].group.name+'</option>')
                    }

                    }
                }
            )
        })
        /**/
        $(document).on("change", "#semser_courses", function () {
            const id = $(this).val();
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('/report/semester_course_change')}}",
                datatype: "JSON",
                success: function (data) {
                    console.log(id)
                    console.log(data.sem_co)
                    $(".course-cont-data").html('')
                    for(var i = 0;i < data.sem_co.lectures.length; i++){
                        $(".course-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.sem_co.lectures[i].created_at+'</td><td>'+data.sem_co.lectures[i].period+'</td></tr>')
                    }
                    }
                }
            )
        })
        /**/
         $("#one-student").submit(function (e) {
            e.preventDefault();
            var search = $("#search").val();
            $.ajax({
                url: "{{url('/report/one-student-report')}}",
                type: "get",
                data: {'search':search},
                datatype: "JSON",
                success: function (dataBack) {
                    console.log(dataBack.result)
                    $(".tab-3-cont-data").html('');
                    for(var i = 0; i < dataBack.result.length; i++){
                        if(dataBack.result[i][5] == 'Success'){
                            $(".tab-3-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td style="color:green">'+dataBack.result[i][5]+'</td></tr>')
                        }else{
                            $(".tab-3-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+dataBack.result[i][0]+'</td><td>'+dataBack.result[i][1]+'</td><td>'+dataBack.result[i][2]+'</td><td>'+dataBack.result[i][3]+'</td><td style="color:red">'+dataBack.result[i][5]+'</td></tr>')
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
        var path = "{{route('tab-3-search')}}";
        $("input.typeahead").typeahead({
            source:function(terms,process){
                return $.get(path,{terms:terms},function(data){
                    return process(data);
                })
            }
        });
        /**/
        $(document).on("click", "#detail", function () {
            var id = $(this).attr("lec-id");
            var lecDate = $(this).attr("lec-date")
            $.ajax({
                type: "get",
                url: "/teacher/report/lecture/detail/"+id,
                data:{'date':lecDate},
                datatype: "JSON",
                success: function (data) {
                        $("#content").html(data);

                    }
                }
            )
        })
    </script>
