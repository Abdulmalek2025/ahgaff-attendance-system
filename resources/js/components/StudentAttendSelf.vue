<template>
    <div id="notify">

    </div>
</template>
<script>
    export default {
        props:['auth'],
        mounted() {
            console.log('self');
            Echo.private('StudentAttendSelf')
            .listen('StudentAttendSelf', (e) => {
                //$course, $teacher, $student_id, $time, $period
                for(let i = 0;i< e.student_id.length; i++){
                    if(this.auth == e.student_id[i].student_id){//check the id of auth in the students array
                        console.log('attendance');
                        $("#notify").append('<hr><div class="notfy"><div class="row"><div class="col-6"><h6>'+e.teacher+'</h6><h6>'+e.course.title+'</h6><p>'+e.time+'</p><button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_studen_attend_self()" class="text-white">View</a></button></div><div class="col-6"><img src="img/openlecture.jpg" width="100%" /></div></div></div></div>')
                        Push.create('Lecture at '+ e.course,{
                        body: e.teacher+" open attendance for "+e.course+" course at "+e.date+".",
                        icon: "img/openlecture.jpg",
                        requireInteraction:true,
                        onClick: function(){
                            $.ajax({
                            url:"/student/attendance/self/"+e.student_id[i].student_id+"/"+e.lecture_id,
                            type:"get",
                            contentType: false,
                            processData: false,
                            success:function(data){
                                window.location.href="http://127.0.0.1:8000/home"
                                alert(data.result)

                            }
                    });
                }
            })
         }
    }

});

        }
    }
</script>
