<template>
    <div id="notify">

    </div>
</template>
<script>
    export default {
        props:['auth'],
        mounted() {
            console.log('well');
            Echo.private('StudentExcusePaid')
            .listen('StudentExcusePaid', (e) => {
                if(this.auth == e.student_id){
                    console.log(e);
                    $("#notify").append('<hr><div class="notfy"><div class="row"><div class="col-6"><h6>'+e.user.email+'</h6><h6>'+e.excuse.title+'</h6><h6>'+e.excuse.status+'</h6><p>'+e.excuse.end_date+'</p><button class="btn btn-primary">View</button></div><div class="col-6"><img src="images/excuse/'+e.excuse.attachments[0].path+'" width="100%" /></div></div></div></div>')
                }
            });

        }
    }
</script>
