<template>
    <div id="notify">

    </div>
</template>
<script>
    export default {
        props:['auth'],
        mounted() {
            console.log('admin');
            Echo.private('AdminExcuse')
            .listen('AdminExcuse', (e) => {
                console.log(this.auth)
                console.log(e.admin_id)
                if(e.admin_id.includes(this.auth)){
                    console.log(e);
                   $("#notify").append('<hr><div class="notfy"><div class="row"><div class="col-6"><h6>'+e.user.email+'</h6><h6>'+e.excuse.title+'</h6><p>'+e.excuse.end_date+'</p><button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_admin_excuse()" class="text-white">View</a></button></div><div class="col-6"><img src="images/excuse/'+e.excuse.attachments[0].path+'" width="100%" /></div></div></div></div>')
                   Push.create(e.excuse.title,{
                    body: "The: "+e.user.email+" apply excuse!",
                    icon: "images/excuse/"+e.excuse.attachments[0].path,
                    requireInteraction:true,

            })
                }
            });

        }
    }
</script>
