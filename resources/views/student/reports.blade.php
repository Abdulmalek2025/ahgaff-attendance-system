<h2>Reports</h2>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div data-tabs class="tabs">
    <div class="d-flex justify-content-around m-auto bg-green rounded">
        <div><label for="tab-1" class="m-1 btn text-white">Semester</label></div>
        <div><label for="tab-2" class="m-1 btn text-white">Courses</label></div>
    </div>
        <div class="tab">
            <input type="radio" name="tabgroup" id="tab-1" checked>
            <label for="tab-1" class="d-none">Semester</label>
            <div class="tab__content">
                <h4 class="mt-3">Current Semester</h4>
                <div class="">
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
                            <tbody class="student-tab-1-cont-data">

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
                <h3 class="pt-3">Status</h3>
                <div class="row">
                    <div class="col"><span>Presence: <span id="presence"></span> </span></div>
                    <div class="col"><span>Absence: <span id="absence"></span> </span></div>
                    <div class="col"><span>Ex-absence: <span id="ex-absence"></span> </span></div>
                    <div class="col"><span>Status: <span id="status"></span> </span></div>
                </div>
                <div>
                    <form id="students" class="pt-3">
                        <div class="form-group">
                            <label>Courses</label>
                            <select name="courses" id="courses" class="form-control">

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
                                    <th scope="col"><input type="checkbox" name="all" id="all"/></th>
                                </tr>
                            </thead>
                            <tbody class="student-tab-2-cont-data">

                            </tbody>
                        </table>
                        <div class="text-center total text-white bg-green rounded"></div>
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
        $(document).ready(function(){
            $.ajax({
                type: "get",
                url: "{{url('/report/student_setup')}}",
                datatype: "JSON",
                success: function (data) {
                    $(".student-tab-1-cont-data").html();
                    $("#courses").html()
                    $("#courses").append('<option value="0">Select</option>')
                    for(var i = 0; i < data.sem_cos.length; i++){
                        $("#courses").append('<option value="'+data.sem_cos[i].id+'">'+data.sem_cos[i].course.name+'</option>')
                        $(".student-tab-1-cont-data").append('<tr><td>'+(1+i)+'</td><td>'+data.sem_cos[i].course.name+'</td><td>'+data.sem_cos[i].teacher.name+'</td><td>'+data.sem_cos[i].group.name+'</td><td>'+data.sem_cos[i].lectures.length+'</td></tr>')
                    }


                }
            })
        });
        /**/
        $(document).on("change", "#courses", function () {
            const id = $(this).val();
            console.log(id)
            $.ajax({
                type: "get",
                data:{'id':id},
                url: "{{url('student/report/change_course')}}",
                datatype: "JSON",
                success: function (data) {//$absence, $ex_absence1, $presence2, $status, $lecs
                    $(".student-tab-2-cont-data").html('')
                    $("#presence").html(data.state[2]+'/'+data.state[4]);
                    $("#absence").html(data.state[0]+'/'+data.state[4]);
                    $("#ex-absence").html(data.state[1]+'/'+data.state[4]);
                    if(data.state[3] == 'Forbidden' || data.state[3] == 'Dismissed'){
                        $("#status").html(data.state[3]);
                        document.getElementById("status").style.color = "red";
                    }else{
                        $("#status").html(data.state[3]);
                        document.getElementById("status").style.color = "green";
                    }
                    for(let i = 0; i < data.result.length; i++){
                        if(data.result[i].is_present == 1){
                            $(".student-tab-2-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.result[i].created_at+'</td><td><input type="checkbox" class="control-input" checked/></td></tr>')
                        }else{
                            $(".student-tab-2-cont-data").append('<tr><td>'+(i+1)+'</td><td>'+data.result[i].created_at+'</td><td><input type="checkbox" class="control-input" /></td></tr>')
                        }

                    }


                    }
                }
            )
        })
</script>
