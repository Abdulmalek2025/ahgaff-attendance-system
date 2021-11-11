<h3>Chat</h3>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div class="container">
    <div id="app">
        <form id="send">
            <div class="form-group">
                <label>Reciever</label>
                <select name="reciever" class="form-control">
                    <option value="Admin">Admin</option>
                    <option value="Dean">Dean</option>
                </select>
                <span class="reciever text-danger"></span>
            </div>
            <div class="form-group">
                <label>Message</label>
                <input type="text" name="message" id="message" class="form-control" />
                <span class="message text-danger"></span>
            </div>
            <input class="btn btn-primary" type="submit" value="Send"/>
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
        $("#send").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#send')[0]);
            $.ajax({
                url: "{{url('student/chat/send')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                        alert(dataBack.success);
                        $("#message").val('')
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("#error").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            })
        })
</script>
