<h1 class="p-3">Excuses</h1>
<div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 mb-3">

            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Student</th>
                            <th score="col">Start Date</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="min-width:130px">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="cont-data">
                    @foreach($rows as $row)
                        <tr id="{{$row->id}}">
                            <td>{{$row->id}}</td>
                            <td class="pl-2">{{$row->student_id}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->status}}</td>

                            <td>
                                <div class="d-flex align-self-center">
                                <div class="text-center">
                                <a href="#" class="excuse-edit-dean" style="padding-top:7px" id-type="{{$row->id}}" type-edit="Other" data-toggle="modal" id-type="{{$row->id}}" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a>
                                </div>
                                <div>
                                @if($row->status == 'Completed')
                                <a href="#" class="btn" ><input type="checkbox" checked id-type="{{$row->id}}" type-edit="Other" data-route="{{url('dean/excuses/accept')}}" id="change_status" style="padding-top:4px;padding-left:15px" /></a>
                                @elseif ($row->status != 'Completed')
                                <a href="#" class="btn" ><input type="checkbox" id-type="{{$row->id}}" type-edit="Other" data-route="{{url('dean/excuses/accept')}}" id="change_status" style="padding-top:4px;padding-left:15px" /></a>
                                @endif
                                </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                        @foreach($rows2 as $row)
                        <tr id="{{$row->id}}">
                            <td>{{$row->id}}</td>
                            <td class="pl-2">{{$row->student_id}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->status}}</td>

                            <td>
                            <div class="d-flex align-self-center">
                                <div class="text-center">
                                <a href="#" class="excuse-edit-dean" style="padding-top:7px" id-type="{{$row->id}}" type-edit="Ill"  data-toggle="modal" id-type="{{$row->id}}" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a>
                                </div>
                                <div>
                                @if($row->status == 'Completed')
                                <a href="#" id="dev" class="btn"><input type="checkbox" checked id="change_status" id-type="{{$row->id}}" type-edit="Ill" data-route="{{url('dean/excuses/accept')}}" style="padding-top:4px;padding-left:15px" /></a>
                                @elseif ($row->status != 'Completed')
                                <a href="#" id="dev" class="btn"><input type="checkbox" id="change_status" id-type="{{$row->id}}" type-edit="Ill" data-route="{{url('dean/excuses/accept')}}" style="padding-top:4px;padding-left:15px" /></a>
                                @endif
                                </div>
                            </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--view Modal -->
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
                          <a hreg="" target="_blank" id="link-image">  <img src="" id="my_image" width="75%" alt="att_image" class="bordered" /> </a>
                        </div>
                        <div class="form-group">
                            <label>Student ID</label>
                            <input type="hidden" id="update-id" name="id" />
                            <input disabled  type="text" name="student_id" class="form-control" id="update-Student_id">
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input disabled typpe="text" name="title" class="form-control" id="update-title">
                        </div>

                        <div disabled class="form-group">
                            <label>Description</label>
                            <textarea disabled name="description" class="form-control" id="update-description"></textarea>
                        </div>
                        <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="update-start_date" />
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" id="update-end_date" />
                    </div>

                    <div class="form-group">
                        <label>Doctor</label>
                        <input disabled type="text" name="doctor" class="form-control" id="update-doctor" />
                    </div>

                    <div class="form-group">
                        <label>Hospital</label>
                        <input disabled type="text" name="hospital" class="form-control" id="update-hospital" />
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input disabled type="text" name="address" class="form-control" id="update-address" />
                    </div>

                    <div class="form-group">
                        <label>Money</label>
                        <input disabled type="number" name="money" class="form-control" id="update-money" />
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select disabled type="text" name="status" class="form-control" id="update-status" >
                            <option>Not Paid</option>
                            <option>Paid</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </div>

                    <h3>Attachment</h3>

                    <div class="form-group">
                        <label>Choose File</label>
                        <input disabled type="file" name="attachment" class="form-con" id="update-attachment" />
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
        //edit    update-student_id,update-title, update-description, update-start_date, update-end_date, update-doctor, update-hospital,update-address,update-money,update-status, update-attachment
        $(document).on("click", ".excuse-edit-dean", function () {
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
                        $("#ill").attr('checked',true);
                        $("#update-doctor").val(data.data.doctor);
                        $("#update-hospital").val(data.data.hospital);
                        $("#update-address").val(data.data.address);
                    }else if(type == 'Other'){
                        $("#other").attr('checked',true)
                        $( "#update-doctor" ).prop( "disabled", true );
                        $( "#update-hospital" ).prop( "disabled", true );
                        $( "#update-address" ).prop( "disabled", true );
                    }
                    $("#update-id").val(data.data.id);
                    $("#update-Student_id").val(data.name.name);
                    $("#update-title").val(data.data.title);
                    $("#update-description").val(data.data.description);
                    $("#update-start_date").val(data.data.start_date);
                    $("#update-end_date").val(data.data.end_date);
                    $("#update-money").val(data.data.money);
                    $("#update-status").val(data.data.status);
                    $("#my_image").attr("src","images/excuse/"+data.attach.path+"");
                    $("#link-image").attr('href',"images/excuse/"+data.attach.path+"")
                }
            })
        })
        $(document).on("click", "#change_status", function(e){
           var route = $(this).attr("data-route");
            var id = $(this).attr("id-type");
            var type = $(this).attr("type-edit");
            var status = '';
            if(this.checked){
                status = "Completed"
            }else{
                status = "Paid"
            }
            $.ajax({
                type: "post",
                data:{'id':id,'type':type,'status':status},
                url: route,
                datatype: "JSON",
                success: function (data) {
                    alert("Excuse status changed successfully!")
                }
            });
        });
        /**/
        $("#edit-excuse").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#edit-excuse')[0]);
            var idRow = $("#update-id").val();
            $.ajax({
                url: "{{url('dean/excuses/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    console.log(dataBack.row)
                    $("#errorUpdate").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#" + idRow).html('')
                    $("#" + idRow).html('<td>'+dataBack.row.id+'</td><td class="pl-2">'+dataBack.row.student_id+'</td><td>'+dataBack.row.start_date+'</td><td>'+dataBack.row.status+'</td><td><div class="d-flex align-self-center"><div class="text-center"><a href="#" class="excuse-edit-dean" style="padding-top:7px" id-type="'+dataBack.row.id+'" type-edit="Ill" data-toggle="modal" id-type="'+dataBack.row.id+'" data-route="{{url('/excuses/edit')}}" data-target="#edit-excuse-modal"><i class="bx bx-edit edit-color"></i></a></div><div><a href="#" id="dev" class="btn"><input type="checkbox" id="change_status" id-type="'+dataBack.row.id+'" type-edit="Ill" data-route="{{url('dean/excuses/accept')}}" style="padding-top:4px;padding-left:15px" /></a></div></div></td>')
                    $('#edit-excuse-modal').modal('hide')
                    $('div').removeClass('modal-backdrop')

                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {

                        $("#errorUpdate").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            })
        })
    </script>
