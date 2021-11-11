<template>
    <div id="notify">

    </div>
</template>
<script>
    export default {
        props:['auth'],
        mounted() {
            console.log('chat');
            Echo.private('SendMessage')
            .listen('SendMessage', (e) => {
                if(this.auth == e.sender_id){
                   $("#notify").append('<div class="notfy"><div class="row"><div class="col-6"><h6>'+e.student.name+'('+e.student.id+'):</h6><h6>'+e.message+'</h6><img src="images/excuse/chat.png" width="100%" /> </div></div></div></div><hr>')
                   Push.create('New message from:'+e.student.name,{
                    body: e.message,
                    requireInteraction:true,

            })
                }
            });

        }
    }
</script>
