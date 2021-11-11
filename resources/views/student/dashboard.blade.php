<h2>Dashboard</h2>
<!--<div class="container mt-5">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
              <div class="card card-stats shadow dashbaord-card">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-5 col-md-4 m-auto">
                      <div class="icon-big text-center icon-warning">
                        <i class="bx bx-bell notify bg-black h1"></i>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
                      <div class="numbers">
                        <p class="h3" id='student-courses'></p>
                        <p class="card-title h3">Courses<p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
              <div class="card card-stats shadow dashbaord-card">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-5 col-md-4 m-auto">
                      <div class="icon-big text-center icon-warning">
                        <i class="bx bx-bell notify bg-black h1"></i>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
                      <div class="numbers">
                        <p class="h3" id='student-groups'></p>
                        <p class="card-title h3">Groups<p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
              <div class="card card-stats shadow dashbaord-card">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-5 col-md-4 m-auto">
                      <div class="icon-big text-center icon-warning">
                        <i class="bx bx-bell notify bg-black h1"></i>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
                      <div class="numbers">
                        <p class="h3" id='student-teachers'></p>
                        <p class="card-title h3">Teachers<p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
</div>-->
    <!--end cards-->
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div class="container mt-3">
    <div class="row cnc">

    </div>
</div>
<div class="container mt-3 mb-5">
    <div class="row m-auto">
        <div class="col-sm-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>

                    <tr>
                        <th scope="col">Course</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Group</th>
                    </tr>
                    </tr>
                </thead>
                <tbody class="data-cont">


                </tbody>
            </table>
        </div>
    </div>
</div><script>
/***/
$.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){

            $.ajax({
                type: "get",
                url: "{{url('/student/setup')}}",
                datatype: "JSON",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                success: function (data) {
                    //console.log(data.rows)
                    $("#student-courses").html(data.courses)
                    $("#student-groups").html(data.groups)
                    $("#student-teachers").html(data.teachers)
                    $(".data-cont").html('')
                    for(var i=0;i< data.rows.length;i++){
                        $(".data-cont").append('<tr><td>'+data.rows[i].course.name+'</td><td>'+data.rows[i].teacher.name+'</td><td>'+data.rows[i].group.name+'</td></tr>')
                        $(".cnc").append('<div class="col-lg-4 col-sm-12 col-md-6 mt-3"><div class="bg-white shadow rounded p-4"><h3 class="text-center">'+data.rows[i].course.name+'</h3><canvas id="myChart'+i+'"></canvas></div></div>')
                        var chart = new Chart("myChart"+i+"", {
                                type: "doughnut",
                                data: {
                                        labels: ['fail','success'],
                                        datasets: [{
                                        backgroundColor: barColors,
                                        data: [16-data.rows[i].lectures.length,data.rows[i].lectures.length]
                                            }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: true
                                            }
                                        }
                                }
                        });
                            }
                }
            })
        })
/**/
    var barColors = [ "rgb(146,0,0)","rgb(16,124,65)"];
    chart = null;




</script>

