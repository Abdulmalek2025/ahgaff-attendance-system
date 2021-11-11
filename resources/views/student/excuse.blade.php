<h1 class="p-3">Excuses</h1>
<div class="loader text-center" id="loader">
    <img src="img/preview.gif" width="30%" />
</div>
<div class="container-fluid">
        <div class="row">
    <div id="test"></div>
            <div class="col-sm-12 mb-3">
                <button class="btn btn-green" id="open-add-modal-student" data-toggle="modal" data-target="#add-excuse-modal-student"> Add New Excuse
                </button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Student</th>
                            <th scope="col">Title</th>
                            <th score="col">Start Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="cont-data-student">
                    @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td>{{$row->id}}</td>
                            <td class="pl-2">{{$row->student_id}}</td>
                            <td>{{$row->title}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->status}}</td>
                            <td>
                                <a href="#" class="excuse-edit" data-toggle="modal" id-type="{{$row->id}}" type-edit="Other" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a>
                                <!--<a href="#" class="excuse-delete" data-toggle="modal" id-type="{{$row->id}}" type-edit="Other" data-route="{{url('/excuses/delete')}}"><i class="bx bxs-trash delete-color"></i></a>-->
                            </td>
                        </tr>
                        @endforeach
                        @foreach($rows2 as $row)
                        <tr id="{{$row->id}}">
                            <td>{{$row->id}}</td>
                            <td class="pl-2">{{$row->student_id}}</td>
                            <td>{{$row->title}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->status}}</td>
                            <td>
                                <a href="#" class="excuse-edit" id-type="{{$row->id}}" type-edit="Ill" data-toggle="modal" id-type="{{$row->id}}" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a>
                                <!--<a href="#" class="excuse-delete" id-type="{{$row->id}}" type-edit="Ill" data-toggle="modal" data-route="{{url('/excuses/delete')}}"><i class="bx bxs-trash delete-color"></i></a>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="add-excuse-modal-student" tabindex="-1" role="dialog" aria-labelledby="add-excuse-modal-studentLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-excuse-student" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-excuse-modal-studentLabel">Add New Excuse</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>
                        <div class="form-group text-center">
                            <label class="radio-inline pl-3 m-3 h4"><input type="radio" checked value="Ill" name="type">ILL</label>
                            <label class="radio-inline pr-3 m-3 h4"><input type="radio" value="Other" name="type">Other</label>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" id="title">
                            <span class="title text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                            <span class="description text-danger"></span>
                        </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" max="{{date('Y-m-d')}}" min="{{date('Y-m-d',strtotime(date('Y-m-d').' -15 days'))}}"  />
                        <span class="start_date text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" max="{{date('Y-m-d')}}" min="{{date('Y-m-d',strtotime(date('Y-m-d').' -15 days'))}}" />
                        <span class="end_date text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label>Doctor</label>
                        <input type="text" name="doctor" class="form-control" id="doctor" />
                        <span class="doctor text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label>Hospital</label>
                        <input type="text" name="hospital" class="form-control" id="hospital" />
                        <span class="hospital text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" id="address" />
                        <span class="address text-danger"></span>
                    </div>

                    <h3>Attachment</h3>

                    <div class="form-group">
                        <label>Choose File</label>
                        <input type="file" name="attachment" class="form-con" id="attachment" />
                        <span class="attachment text-danger"></span>
                    </div>
                    </div>
                    <div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input disabled id="add_new_excuse" type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--update Modal -->
    <div class="modal fade" id="edit-excuse-modal" tabindex="-1" role="dialog" aria-labelledby="edit-excuse-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit-excuse">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-excuse-modalLabel">Edit Excuse</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="errorUpdate" class="list-unstyled"></ul>
                        <div class="form-group text-center">
                            <label class="radio-inline pl-3 m-3 h4"><input id="ill" value="Ill" type="radio" name="type">Ill</label>
                            <label class="radio-inline pr-3 m-3 h4"><input id="other" value="Other" type="radio" name="type">Other</label>
                        </div>
                        <div class="text-center">
                          <a href="#" target="_blank" id="link-image">  <img src="" id="my_image" width="75%" alt="att_image" class="bordered" /> </a>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="hidden" id="update-id" name="id" />
                            <input typpe="text" name="title" class="form-control" id="update-title">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id="update-description"></textarea>
                        </div>
                        <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="update-start_date" max="{{date('Y-m-d')}}" min="{{date('Y-m-d',strtotime(date('Y-m-d').' -15 days'))}}" />
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" id="update-end_date" max="{{date('Y-m-d')}}" min="{{date('Y-m-d',strtotime(date('Y-m-d').' -15 days'))}}"/>
                    </div>

                    <div class="form-group">
                        <label>Doctor</label>
                        <input type="text" name="doctor" class="form-control" id="update-doctor" />
                    </div>

                    <div class="form-group">
                        <label>Hospital</label>
                        <input type="text" name="hospital" class="form-control" id="update-hospital" />
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" id="update-address" />
                    </div>

                    <h3>Attachment</h3>

                    <div class="form-group">
                        <label>Choose File</label>
                        <input type="file" name="attachment" class="form-con" id="update-attachment" />
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!--<input type="submit" class="btn btn-primary" value="Save changes" name="submit">-->
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
        $("#add-excuse-student").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#add-excuse-student')[0]);
            $.ajax({
                url: "{{url('student/excuses/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $(".cont-data-student").prepend(dataBack)
                    $('#add-excuse-modal-student').modal('hide')
                    $('div').removeClass('modal-backdrop')

                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
        //send broadcast

        //delte
        $(document).on("click", ".excuse-delete", function () {
            var route = $(this).attr("data-route");
            var id = $(this).attr("id-type");
            var type = $(this).attr("type-edit");
            $.ajax({
                type: "get",
                data:{'type':type,'id':id},
                url: route,
                success: function (data) {
                    console.log(id);
                    alert(data.success);
                    $("#" + data.id).remove();
                }
            })
        })
        //edit    update-student_id,update-title, update-description, update-start_date, update-end_date, update-doctor, update-hospital,update-address,update-money,update-status, update-attachment
        $(document).on("click", ".excuse-edit", function () {
            var route = $(this).attr("data-route");
            var id = $(this).attr("id-type");
            var type = $(this).attr("type-edit");
            $.ajax({
                type: "get",
                data:{'type':type,'id':id},
                url: route,
                datatype: "JSON",
                success: function (data) {
                    console.log(type);
                    console.log(id);
                    console.log(data.data);
                    $("#edit-excuse")[0].reset()
                    if(type == 'Ill'){
                        $("#other").attr('checked',false);
                        $("#ill").attr('checked',true);
                        $("#update-doctor").val(data.data.doctor);
                        $("#update-hospital").val(data.data.hospital);
                        $("#update-address").val(data.data.address);
                    }else if(type == 'Other'){
                        $("#ill").attr('checked',false);
                        $("#other").attr('checked',true)
                        $( "#update-doctor" ).prop( "disabled", true );
                        $( "#update-hospital" ).prop( "disabled", true );
                        $( "#update-address" ).prop( "disabled", true );
                    }
                    $("#update-id").val(data.data.id);
                    $("#update-title").val(data.data.title);
                    $("#update-description").val(data.data.description);
                    $("#update-start_date").val(data.data.start_date);
                    $("#update-end_date").val(data.data.end_date);
                    $("#my_image").attr("src","images/excuse/"+data.attach.path);
                    $("#link-image").attr('href',"images/excuse/"+data.attach.path)
                    console.log(data.attach.path)
                }
            })
        })
        //  update
        $("#edit-excuse").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#edit-excuse')[0]);
            var idRow = $("#update-id").val();
            $.ajax({
                url: "{{url('student/excuses/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $("#" + idRow).html('')
                    $("#" + idRow).html(dataBack)
                    $('#edit-excuse-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')
                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("."+key).html(item)
                    })
                }
            })
        })
    </script>
