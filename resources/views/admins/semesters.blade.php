<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mb-3">
            <h2 class="col-12 my-3 p-0">Semester</h2>
                <button class="btn btn-green" data-toggle="modal" data-target="#add-semester-modal"> Add New Semester
                </button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>

                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="cont-data">
                        @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td class="pl-2">{{$row->id}}</td>
                            <td style="min-width:200px;">{{$row->name}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->end_date}}</td>

                            <td>
                                <a href="#" class="semester-edit" data-toggle="modal"
                                    data-route="{{url('/semesters/edit/'.$row->id)}}" data-target="#edit-semester-model"><i
                                        class="bx bx-edit edit-color"></i></a>
                                <!--<a href="#" class="semester-delete" data-toggle="modal"
                                    data-route="{{url('/semesters/delete/'.$row->id)}}"><i class="bx bxs-trash delete-color"></i></a>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--collages-->
            <div class="m-3">
            <h3 class="col-12 my-3 p-0">Collages</h3>
                <button class="btn btn-green" data-toggle="modal" data-target="#add-collage-modal"> Add New Collage
                </button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="collage-cont-data">
                        @foreach($collages as $collage)
                        <tr id="{{'collage'.$collage->id}}">
                            <td class="pl-2">{{$collage->id}}</td>
                            <td style="min-width:200px;">{{$collage->name}}</td>
                            <td>{{$collage->location}}</td>
                            <td>{{$collage->telephone}}</td>
                            <td>
                                <a href="#" class="collage-edit" data-toggle="modal"
                                    data-route="{{url('/collage/edit/'.$collage->id)}}" data-target="#edit-collage-model"><i
                                        class="bx bx-edit edit-color"></i></a>
                                <!--<a href="#" class="collage-delete" data-toggle="modal"
                                    data-route="{{url('/collage/delete/'.$collage->id)}}"><i class="bx bxs-trash delete-color"></i></a>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--majors-->
            <div class="m-3">
            <h3 class="col-12 my-3 p-0">Majors</h3>
                <button class="btn btn-green" data-toggle="modal" data-target="#add-major-modal"> Add New Major
                </button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Collage</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="major-cont-data">
                        @foreach($majors as $major)
                        <tr id="{{'major'.$major->id}}">
                            <td class="pl-2">{{$major->id}}</td>
                            <td style="min-width:200px;">{{$major->name}}</td>
                            <td>{{$major->collage()->first()->name}}</td>
                            <td>
                                <a href="#" class="major-edit" data-toggle="modal"
                                    data-route="{{url('/major/edit/'.$major->id)}}" data-target="#edit-major-model"><i
                                        class="bx bx-edit edit-color"></i></a>
                                <a href="#" class="major-delete" data-toggle="modal"
                                    data-route="{{url('/major/delete/'.$major->id)}}"><i class="bx bxs-trash delete-color"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add semester Modal -->
    <div class="modal fade" id="add-semester-modal" tabindex="-1" role="dialog" aria-labelledby="semestereModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-semester">
                    <div class="modal-header">
                        <h4 class="modal-title" id="semesterModalLabel">Add New Semester</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="semester-error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <span class="name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                            <span class="start_date text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" autocomplete="end_date">
                            <span class="end_date text-danger"></span>
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
    <!--update semester Modal -->
    <div class="modal fade" id="edit-semester-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="update-semester">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Edit Semester</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="update-semester-error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                            <input type="hidden" id="id" name="id">
                            <span class="name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" />
                            <span class="start_date text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" autocomplete="end_date">
                            <span class="end_date text-danger"></span>
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
    <!--add collage model-->
    <div class="modal fade" id="add-collage-modal" tabindex="-1" role="dialog" aria-labelledby="collageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-collage">
                    <div class="modal-header">
                        <h4 class="modal-title" id="collageModalLabel">Add New Collage</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="collage-error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="collage" class="form-control">
                            <span class="collage text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control">
                            <span class="location text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="number" name="telephone" class="form-control">
                            <span class="telephone text-danger"></span>
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
    <!--update collage model-->
    <div class="modal fade" id="edit-collage-model" tabindex="-1" role="dialog" aria-labelledby="collageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="update-collage">
                    <div class="modal-header">
                        <h4 class="modal-title" id="collageModalLabel">Edit Collage</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="update-collage-error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="update-collage-name" name="update_collage_name" class="form-control">
                            <input type="hidden" id="collage-id" name="collage_id">
                            <span class="update_collage_name text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" id="update-collage-location" name="update_collage_location" class="form-control">
                            <span class="update_collage_location text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="number" id="update-collage-telephone" name="update_collage_telephone" class="form-control">
                            <span class="update_collage_telephone text-danger"></span>
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
    <!--add major-->
    <div class="modal fade" id="add-major-modal" tabindex="-1" role="dialog" aria-labelledby="majorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-major">
                    <div class="modal-header">
                        <h4 class="modal-title" id="majorModalLabel">Add New Major</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="major-error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="major_name" class="form-control">
                            <span class="major_name text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Collages</label>
                            <select name="major_collages" id="major-collages" class="form-control">
                                 @foreach($collages as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>

                                @endforeach
                            </select>
                            <span class="major_collages"></span>
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
    <!--update major-->
    <div class="modal fade" id="edit-major-model" tabindex="-1" role="dialog" aria-labelledby="majorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="update-major">
                    <div class="modal-header">
                        <h4 class="modal-title" id="majorModalLabel">Edit Major</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="update-major-error" class="list-unstyled"></ul>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="update-major-name" name="update_major_name" class="form-control">
                            <input type="hidden" id="major-id" name="major_id">
                            <span class="update_major_name text-danger"></span>
                        </div>

                        <div class="form-group">
                        <label>Collages</label>
                            <select class="form-control" name="update_major_collages" id="update-major-collages">
                                @foreach($collages as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>

                                @endforeach
                            </select>
                            <span class="update_major_collages text-danger"></span>
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
        $(function () {
            setTimeout(() => {
                $(".loader").fadeOut(500);
            }, 2000);
        });
        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#add-semester").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-semester')[0]);
            $.ajax({
                url: "{{url('/semesters/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    if(dataBack.error == 'This row already exit'){
                        $("#semester-error").html("<li class='alert alert-danger text-center p-1'>"+dataBack.error+"</li>")
                    }else{
                        $(".cont-data").prepend(dataBack)
                        $('#add-semester-modal').modal('hide')
                        $('div').removeClass('modal-backdrop')
                        $('#add-semester')[0].reset();
                        /**/
                        $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                        /**/
                    }


                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        //delte
        $(document).on("click", ".semester-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for deleting!')
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
        $(document).on("click", ".semester-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $("#start_date").val(data.data.start_date);
                    $("#end_date").val(data.data.end_date);

                }
            })
        })
        //  update
        $("#update-semester").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-semester')[0]);
            var idRow = $("#id").val();
            // console.log(formData);
            $.ajax({
                url: "{{url('/semesters/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    if(dataBack.state == 'This row is already exit'){
                        $("#update-semester-error").html("<li class='alert alert-success text-center p-1'>"+dataBack.state+"</li>");
                    }else{
                        $("#" + idRow).html('')
                        $("#" + idRow).html(dataBack)
                        $('#edit-semester-model').modal('hide')
                        $('div').removeClass('modal-backdrop')
                        $('#add-semester')[0].reset();
                        $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    }
                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        /*collage*/
        $("#add-collage").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-collage')[0]);
            $.ajax({
                url: "{{url('/collage/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    if(dataBack.state == 'This row is already exit'){
                        $("#collage-error").html('This row is already exit');
                    }else{
                        $(".collage-cont-data").prepend(dataBack)
                        $('#add-collage-modal').modal('hide')
                        $('div').removeClass('modal-backdrop')
                        $('#add-collage')[0].reset();
                    }

                    /**/
                    $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    /**/
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        /**/
        $(document).on("click", ".collage-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for delete?')
            if(check){
                $.ajax({
                type: "get",
                url: route,
                success: function (data) {
                    $("#collage" + data.id).remove();
                    $("#major-collages").html('')
                    for(let i = 0;i < data.collages.length;i++){
                        $("#major-collages").append('<option value="'+data.collages[i].id+'">'+data.collages[i].name+'</option>')
                    }
                    for(let i = 0;i < data.majors.length;i++){
                        $("#major" + data.majors[i].id).remove();
                    }
                }
            })
            }
        })
        /**/
        $(document).on("click", ".collage-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#collage-id").val(data.data.id);
                    $("#update-collage-name").val(data.data.name);
                    $("#update-collage-location").val(data.data.location);
                    $("#update-collage-telephone").val(data.data.telephone);
                }
            })
        })
        /**/
        $("#update-collage").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-collage')[0]);
            var idRow = $("#collage-id").val();
            $.ajax({
                url: "{{url('/collage/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    //$("#update-collage-error").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#collage" + idRow).html('')
                    $("#collage" + idRow).html(dataBack)
                    $('#edit-collage-model').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        /*major*/
        $("#add-major").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-major')[0]);
            $.ajax({
                url: "{{url('/major/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    if(dataBack.state == 'This row already exit'){
                        $("#major-error").html("<li class='alert alert-danger text-center p-1'>"+dataBack.state+"</li>")
                    }else{
                        $(".major-cont-data").prepend(dataBack)
                        $('#add-major-modal').modal('hide')
                        $('div').removeClass('modal-backdrop')
                        $('#add-major')[0].reset();
                    }
                    /**/
                    $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    /**/
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        /**/
        $(document).on("click", ".major-delete", function () {
            var route = $(this).attr("data-route");
            let check = confirm('Are you sure for deleting?')
            if(check){
                $.ajax({
                type: "get",
                url: route,
                success: function (data) {
                    $("#major" + data.id).remove();
                }
            })
            }
        })
        /**/
        $(document).on("click", ".major-edit", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                datatype: "JSON",
                success: function (data) {
                    $("#major-id").val(data.data.id);
                    $("#update-major-name").val(data.data.name);
                    $("#update-major-collages").html('')
                    for(let i = 0; i < data.collages.length; i++){
                        if(data.data.collage_id == data.collages[i].id){
                            $("#update-major-collages").append('<option selected value="'+data.collages[i].id+'">'+data.collages[i].name+'</option>')
                        }
                        else{
                            $("#update-major-collages").append('<option value="'+data.collages[i].id+'">'+data.collages[i].name+'</option>')
                        }
                    }

                }
            })
        })
        /**/
        $("#update-major").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#update-major')[0]);
            var idRow = $("#id").val();
            $.ajax({
                url: "{{url('/major/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    //$("#update-major-error").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#major" + idRow).html('')
                    $("#major" + idRow).html(dataBack)
                    $('#edit-major-model').modal('hide')
                    $('div').removeClass('modal-backdrop')
                    /**/
                    $.ajax({
                        url:"/admin/semesters",
                        type:"get",
                        beforeSend:function(){
                            $("#loader").show()
                        },
                        complete:function(c){
                            $("#loader").hide(1000)
                        },
                        success:function(data){
                            $("#content").html(data);

                        }
                    });
                    /**/
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
    </script>
