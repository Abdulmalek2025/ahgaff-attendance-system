<h2>Open Lecture</h2>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h6>Today: {{date('d/m/Y H:i:s')}}</h6>
        </div>
        <form class="w-100 d-contents" id="open-form" style="display:contents">
            <div class="form-group col-md-12 mb-3">
                <label>Attendance:</label>
                <select name="type" id="type" class="custom-select form-control border-success">
                    <option value="Teacher only">Teacher only</option>
                    <option value="With student">With student</option>
                    <option value="Fingerprint">Fingerprint</option>
                </select>
                <span class="type text-danger"><span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label>Semester Course</label>
                <select name="sem_co" id="sem_co" class="custom-select form-control border-success">

                </select>
                <span class="sem_co text-danger"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label>period</label>
                <input name="period" id="period" class="custom-select form-control border-success"/>
                <span class="period text-danger"></span>
            </div>
            <div class="col-md-6" id="change-btn">
                @if($check != null)
                <input type="hidden" value="{{$check->id}}" id="lecture_id" />
                <a href="#"  class="btn btn-green w-100 mb-3" onclick="confirm_lecture()"> Confirm </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-green w-100 mb-3" onclick="delete_lecture()"> Delete </a>
                </div>
                @elseif ($check == null)
                <input type="hidden" value="" id="lecture_id" />
                <input  type="submit" value="Open" class="btn btn-green w-100 mb-3"/>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-green w-100 mb-3"> Delete </a>
                </div>
                @endif

        </form>
    </div>
</div>
<script src="../resources/js/bootstrap.js"></script>
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
                url: "{{url('/lecture/set-sem-co')}}",
                datatype: "JSON",
                success: function (data) {
                    $("#sem_co").html("")
                    for(var i=0; i<data.sem.length;i++){
                        if(data.one != null){
                          if(data.one.id == data.sem[i].id){
                            $("#sem_co").attr('disabled',true)
                            $("#sem_co").append('<option selected value='+data.sem[i].id+'>'+data.sem[i].course.name +' | '+ data.sem[i].teacher.name +' | '+data.sem[i].group.name+' | '+data.sem[i].semester.name+'</option>')
                            }
                        }
                        else{
                            $("#sem_co").append('<option value='+data.sem[i].id+'>'+data.sem[i].course.name +' | '+ data.sem[i].teacher.name +' | '+data.sem[i].group.name+' | '+data.sem[i].semester.name+'</option>')
                        }

                    }
                }
            })
    });
    $("#open-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(jQuery('#open-form')[0]);
        var idRow = $("#id").val();
        // console.log(formData);
        $.ajax({
            url: "{{url('/teacher/open')}}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (dataBack) {
                $("#change-btn").html('<a href="#"  class="btn btn-green w-100 mb-3" onclick="confirm_lecture()"> Confirm </a>')
                alert('lecture opened successfully')
                $("#type").attr('disabled',true)
                $("#sem_co").attr('disabled',true)
                $("#period").attr('disabled',true)
                /**/
                $.ajax({
                    url:"/teacher/lecture",
                    beforeSend:function(){
                        $("#loader").show()
                    },
                    complete:function(c){
                        $("#loader").hide(1000)
                    },
                    type:"get",
                    success:function(data){
                        console.log(data);
                        $("#content").html(data);
                    }
            });

            }, error: function (xhr, status, error) {
                // console.log(xhr.responseJSON.errors);
                $.each(xhr.responseJSON.errors, function (key, item) {
                    $("."+key).html(item);
                })
            }
        })
    })
    /**/
    function confirm_lecture(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
            const lecture_id = $("#lecture_id").val()
            const sem_co = $("#sem_co").val()
            $.ajax({
                url:"/teacher/confirm",
                type:"get",
                data:{
                    CSRF_TOKEN, lecture_id, sem_co
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        /**/
    function delete_lecture(){
            event.preventDefault();
            const id = $("#lecture_id").val()
            $.ajax({
                url:"/teacher/delete/lecture",
                type:"post",
                data:{'id':id},
                success:function(data){
                    $("#sem_co").html('')
                    if($("#lecture_id").val() > 0){
                        console.log(data.sem_cos)
                        for(let i = 0; i< data.sem_cos.length; i++){
                            $("#sem_co").append('<option value='+data.sem_cos[i].id+'>'+data.sem_cos[i].course.name +' | '+data.sem_cos[i].group.name+' | '+data.sem_cos[i].semester.name+'</option>')
                        }
                        $("#sem_co").attr('disabled',false)
                        alert('Lecture was deleted successfully!')
                        /**/
                        $.ajax({
                                url:"/teacher/lecture",
                                beforeSend:function(){
                                    $("#loader").show()
                                },
                                complete:function(c){
                                    $("#loader").hide(1000)
                                },
                                type:"get",
                                success:function(data){
                                    console.log(data);
                                    $("#content").html(data);
                                }
                        });
                    }



                }
            });
        }
</script>
