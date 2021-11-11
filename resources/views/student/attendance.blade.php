<h1 class="p-3">Attendance</h1>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
    <div class="container-fluid">
        <div>
            <form id="student-attendance">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Teacher</label>
                            <input type="hidden" id="student-id-attendance" name="student-id-attendance" />
                            <input type="text" id="teacher-student-attendance" class="form-control" name="teacher_student_attendance" readonly />
                            <span class="teacher_student_attendance text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Course</label>
                            <input type="text" id="course-student-attendance" class="form-control" name="course_student_attendance" readonly />
                            <span class="course_student_attendance"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Open Time</label>
                            <input type="text" id="open-time-student-attendance" class="form-control" name="open_time_student_attendance" readonly />
                            <span class="open_time_student_attendance text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>period</label>
                            <input type="text" id="period-student-attendance" class="form-control" name="period_student_attendance" readonly />
                            <span class="period_student_attendance text-danger"></span>
                        </div>
                    </div>
                </div>
                <div col="col-12 p-3">
                    <div class="d-flex justify-content-around">
                        <input class="btn btn-green" type="submit" value="Attend"/>
                    </div>
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
        $("#student-attendance").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#student-attendance')[0]);
            $.ajax({
                url: "{{url('student/attendance/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {

                }, error: function (xhr, status, error) {

                }
            })
        })
    </script>
