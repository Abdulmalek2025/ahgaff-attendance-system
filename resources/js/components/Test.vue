<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">test Component</div>
                    <div id="users"></div>
                    <div class="card-body">
                        I'm an test component.
                    </div>
                    <div>{{auth}}</div>
                    <div id="note"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['auth'],
        mounted() {
            console.log(this.auth);
            if(this.auth == 1){
                Echo.private('DeanExcuse')
            .listen('DeanExcuse', (e) => {
                console.log(e);
                $("#note").html(e.excuse.title)
    });
            }


        }
    }
</script>
