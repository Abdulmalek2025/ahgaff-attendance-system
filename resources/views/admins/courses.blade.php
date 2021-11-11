 <h1 class="p-3">Courses</h1>
 <div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 mb-3">
                <button class="btn btn-green" data-toggle="modal" data-target="#add-course-modal"> Add New Course </button>
                <i class="fa fa-refresh"></i>

            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>

                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="cont-data">
                        @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td class="pl-2">{{$row->id}}</td>
                            <td style="min-width:200px;">{{$row->name}}</td>
                            <td>{{$row->description}}</td>
                            <td>{{$row->credit}}</td>

                            <td>
                                <a href="#" class="course-edit" data-toggle="modal"
                                    data-route="{{url('/courses/edit/'.$row->id)}}" data-target="#edit-course-modal"><i
                                        class="bx bx-edit edit-color"></i></a>
                               <a href="#" class="course-delete" data-toggle="modal"
                                    data-route="{{url('/courses/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="add-course-modal" tabindex="-1" role="dialog" aria-labelledby="add-course-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-course">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-course-modalLabel">Add New Course</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <span class="name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control">
                            <span class="description text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Credit</label>
                            <input type="text" name="credit" class="form-control" />
                            <span class="credit text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--update Modal -->
    <div class="modal fade" id="edit-course-modal" tabindex="-1" role="dialog" aria-labelledby="edit-course-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="update-course">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-course-modalLabel">Edit Course</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="errorUpdate" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                            <input type="hidden" id="id" name="id">
                            <span class="name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control" />
                            <span class="description text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Credit</label>
                            <input type="text" name="credit" id="credit" class="form-control" autocomplete="credit">
                            <span class="credit text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#add-course").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-course')[0]);
            $.ajax({
                url: "{{url('/courses/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    //$("#error").html("<li class='alert alert-success text-center p-1'>  </li>");
                    $(".cont-data").prepend(dataBack)
                    $('#add-course-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    /**/
                    $.ajax({
                        url:"/admin/courses",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide()
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    /**/
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item);
                    })
                }
            })
        })
        //delte
        $(document).on("click", ".course-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for delete!');
            if(check){
                $.ajax({
                type: "get",
                url: route,
                success: function (data) {
                    alert(data.success);
                    $("#" + data.id).remove();
                }
            })
            }

        })
        //edit
        $(document).on("click", ".course-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $("#description").val(data.data.description);
                    $("#credit").val(data.data.credit);

                }
            })
        })
        //  update
        $("#update-course").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-course')[0]);
            var idRow = $("#id").val();
            $.ajax({
                url: "{{url('/courses/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    //$("#errorUpdate").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#" + idRow).html('')
                    $("#" + idRow).html(dataBack)
                    $('#edit-course-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')

                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {

                        $("."+key).html(item);
                    })
                }
            })
        })
    </script>

