<!doctype html>
<html lang="en">
<div class="loader text-center">
    <img src="{{ asset('img/preview.gif') }}">
</div>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/fonts/all.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transformations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boxicons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/boxicons.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Home Page </title>
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="d-flex">
            <div class="header__notify">
                @auth
                @if(Auth::user()->type == 'admin')
                <a href="{{ route('register') }}" class="mr-2">
                    <i class="bx bxs-user-plus notify"></i>
                </a>
                @endif
                @endauth
            </div>
            <div class="header__notify">
                <a href="#">
                    <i class="bx bx-bell notify"></i>
                </a>
                <span class="notify_count">6</span>
            </div>
        </div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>

                <a href="#" class="nav__logo">
                    <img src="img/logo.jpg" alt="" class="header__img">
                    <span class="nav__logo-name">@guest guset@mail.com @else {{ Auth::user()->email }} @endguest</span>
                </a>

                <div class="nav__list">
                    @auth
                    @if( Auth::user()->type == 'Admin')
                    <a href="#" class="nav__link active">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="{{ route('admins.index')}}" class="nav__link">
                        <i class='bx bxs-user nav__icon'></i>
                        <span class="nav__name">Admins</span>
                    </a>

                    <a href="{{ route('teachers.index')}}" class="nav__link">
                        <i class='bx bxs-user-pin nav__icon'></i>
                        <span class="nav__name">Teachers</span>
                    </a>

                    <a href="{{ route('students.index') }}" class="nav__link">
                        <i class='bx bxs-user-check nav__icon'></i>
                        <span class="nav__name">Students</span>
                    </a>

                    <a href="{{ Route('courses.index') }}" class="nav__link">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Courses</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-group nav__icon'></i>
                        <span class="nav__name">Groups</span>
                    </a>

                    <a href="{{ Route('semesters.index') }}" class="nav__link">
                        <i class='bx bx-timer nav__icon'></i>
                        <span class="nav__name">Semesters</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-calendar-check nav__icon'></i>
                        <span class="nav__name">Attendance</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-calendar-exclamation nav__icon'></i>
                        <span class="nav__name">Excuses</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Timetables</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    @elseif( Auth::user()->type == 'Dean')
                    <!--Dean-->
                    <a href="#" class="nav__link">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bxs-message-alt-check nav__icon'></i>
                        <span class="nav__name">Accept Excuse</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    @elseif( Auth::user()->type == 'Teacher')
                    <!--teacher-->
                    <a href="#" class="nav__link">
                        <i class='bx bxs-door-open nav__icon'></i>
                        <span class="nav__name">Open Lecture</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bxs-user-check nav__icon'></i>
                        <span class="nav__name">Confirm Attendance</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    @elseif( Auth::user()->type == 'Student')
                    <!--student-->
                    <a href="#" class="nav__link">
                        <i class='bx bxs-calendar-check nav__icon'></i>
                        <span class="nav__name">Attend self</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bxs-calendar-plus nav__icon'></i>
                        <span class="nav__name">Apply Excuse</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>

                    <a href="#" class="nav__link">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    @endif
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="nav__link">
                        <i class='bx bx-log-out nav__icon'></i>
                        <span class="nav__name">{{ __('Logout') }}</span>
                    </a>
                    @endauth
                </div>

            </div>
        </nav>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <h1 class="p-3">All Semesters! <i class="bx bxs-user"></i> </h1>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 mb-3">
                <button class="btn btn-green" data-toggle="modal" data-target="#exampleModal"> Add New Semester
                </button>
                <i class="fa fa-refresh"></i>

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
                                <a href="#" class="edit" data-toggle="modal"
                                    data-route="{{url('/semesters/edit/'.$row->id)}}" data-target="#exampleModal2"><i
                                        class="bx bx-edit"></i></a>
                                <a href="#" class="delete" data-toggle="modal"
                                    data-route="{{url('/semesters/delete/'.$row->id)}}"><i class="bx bxs-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addClient">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add New Semester</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" autocomplete="end_date">
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
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateClient">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Edit Semester</i></h4>
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
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" autocomplete="credit">
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('/assets')}}/js/jquery-3.4.1.js"></script>
    <script src="{{asset('/assets')}}/js/popper.min.js"></script>
    <script src="{{asset('/assets')}}/js/bootstrap.min.js"></script>


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

        $("#addClient").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#addClient')[0]);
            $.ajax({
                url: "{{url('/semesters/store')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $("#error").html("<li class='alert alert-success text-center p-1'> Added Success </li>");
                    $(".cont-data").prepend(dataBack)
                    $('#exampleModal').modal('hide')

                }, error: function (xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $("#error").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            })
        })
        //delte
        $(document).on("click", ".delete", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "get",
                url: route,
                success: function (data) {
                    alert(data.success);
                    $("#" + data.id).remove();
                }
            })
        })
        //edit
        $(document).on("click", ".edit", function () {
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

        $("#updateClient").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(jQuery('#updateClient')[0]);
            var idRow = $("#id").val();
            // console.log(formData);
            $.ajax({
                url: "{{url('/semesters/update')}}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (dataBack) {
                    $("#errorUpdate").html("<li class='alert alert-success text-center p-1'> Edited Success </li>");
                    $("#" + idRow).html('')
                    $("#" + idRow).html(dataBack)
                    $('#exampleModal2').modal('hide')

                }, error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function (key, item) {

                        $("#errorUpdate").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            })
        })
    </script>
</body>

</html>
