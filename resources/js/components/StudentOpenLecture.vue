<template>
    <div id="notify">

    </div>
</template>
<script>
    export default {
        props:['auth'],
        mounted() {
            console.log('open');
            Echo.private('StudentOpenLecture')
            .listen('StudentOpenLecture', (e) => {
                for(let i = 0;i< e.student_id.length; i++){
                    if(this.auth == e.student_id[i].student_id){
                        console.log(e);
                        $("#notify").append('<hr><div class="notfy"><div class="row"><div class="col-6"><h6>'+e.course+'</h6><h6>'+e.teacher+'</h6><p>'+e.date+'</p><button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" class="text-white">View</a></button></div><div class="col-6"><img src="img/openlecture.jpg" width="100%" /></div></div></div></div><hr>')
                        Push.create(e.course,{
                        body: `${e.teacher} open lecture at ${e.date}`,
                        icon: "img/openlecture.jpg",
                        requireInteraction:true,
                        })
                }
            }

            });

        }
    }
</script>
