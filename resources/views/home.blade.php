<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <script src="{{asset('/assets/js/jquery-3.4.1.js')}}"></script>
    <script src="{{asset('/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
   <!-- <script src="{{asset('js/datatable.min.js')}}"></script>-->

    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/fonts/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/datatable.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transformations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boxicons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/boxicons.js') }}" defer></script>
    <script src="{{asset('/assets/js/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="js/chart.min.js"></script>
    <script src="{{ asset('js/serviceWorker.js') }}" defer></script>
    <script src="{{ asset('js/push.min.js') }}" defer></script>
    <script src="{{asset('js/bootstrap3-typeahead.min.js')}}"></script>
    <!--<script src="js/chart.esm.min.js"></script>-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body id="body-pd">

    <header class="header" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="d-flex">
            <div class="header__notify">
            @if (Auth::user()->type == 'Teacher')
                <a href="#" data-toggle="modal" data-target="#teacher-note">
                    <i class="bx bx-bell notify"></i>
                </a>
                <span class="notify_count">0</span>
            @elseif(Auth::user()->type == 'Student')
                <a href="#" data-toggle="modal" data-target="#student-note">
                    <i class="bx bx-bell notify"></i>
                </a>
                <span class="notify_count">0</span>
            @elseif(Auth::user()->type == 'Master')
                <a href="#" data-toggle="modal" data-target="#master-note">
                    <i class="bx bx-bell notify"></i>
                </a>
                <span class="notify_count">0</span>
            @elseif(Auth::user()->type == 'Admin')
                <a href="#" data-toggle="modal" data-target="#admin-note">
                    <i class="bx bx-bell notify"></i>
                </a>

                <span class="notify_count">6</span>
            @elseif(Auth::user()->type == 'Dean')
                <a href="#" data-toggle="modal" data-target="#dean-note">
                    <i class="bx bx-bell notify"></i>
                </a>
                <span class="notify_count">0</span>
            @endif
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
                    @if (Auth::user()->type == 'Master')

                        <a href="#" class="nav__link" onclick="semesters()">
                            <i class='bx bx-timer nav__icon'></i>
                            <span class="nav__name">General Setting</span>
                        </a>
                        <a href="#" class="nav__link" onclick="admins()">
                            <i class='bx bxs-user nav__icon'></i>
                            <span class="nav__name">Admins</span>
                        </a>

                        <a href="#" class="nav__link" onclick="mreports()">
                            <i class='bx bx-book-content nav__icon'></i>
                            <span class="nav__name">Report</span>
                        </a>
                        <a href="#" class="nav__link" onclick="mprofile()">
                            <i class='bx bxs-user-detail nav__icon'></i>
                            <span class="nav__name">Profile</span>
                        </a>

                    @elseif( Auth::user()->type == 'Admin')
                    <a href="#" class="nav__link active" onclick="dashboard()">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>


                    <a href="#" class="nav__link" onclick="teachers()">
                        <i class='bx bxs-user-pin nav__icon'></i>
                        <span class="nav__name">Teachers</span>
                    </a>

                    <a href="#" class="nav__link" onclick="students()">
                        <i class='bx bxs-user-check nav__icon'></i>
                        <span class="nav__name">Students</span>
                    </a>

                    <a href="#" class="nav__link" onclick="courses()">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Courses</span>
                    </a>

                    <a href="#" class="nav__link" onclick="groups()">
                        <i class='bx bx-group nav__icon'></i>
                        <span class="nav__name">Groups</span>
                    </a>
                    <a href="#" class="nav__link" onclick="semester_course()">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Semester Course</span>
                    </a>

                    <a href="#" class="nav__link" onclick="attendances()">
                        <i class='bx bx-calendar-check nav__icon'></i>
                        <span class="nav__name">Attendance</span>
                    </a>

                    <a href="#" class="nav__link" onclick="excuses()">
                        <i class='bx bx-calendar-exclamation nav__icon'></i>
                        <span class="nav__name">Excuses</span>
                    </a>

                    <a href="#" class="nav__link" onclick=reports()>
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    <a href="#" class="nav__link" onclick=upgrade()>
                        <i class='bx bx-archive-out nav__icon'></i>
                        <span class="nav__name">Upgrade</span>
                    </a>
                    <a href="#" class="nav__link" onclick="mprofile()">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>
                    @elseif( Auth::user()->type == 'Dean')
                    <!--Dean-->
                    <a href="#" class="nav__link active" onclick="dean_dashboard()">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="#" class="nav__link" onclick="accept_excuses()">
                        <i class='bx bxs-message-alt-check nav__icon'></i>
                        <span class="nav__name">Accept Excuse</span>
                    </a>

                    <a href="#" class="nav__link" onclick="dean_report()">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>

                    <a href="#" class="nav__link" onclick="profile()">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>
                    @elseif( Auth::user()->type == 'Teacher')
                    <!--teacher-->
                    <a href="#" class="nav__link active" onclick="teacher_dashboard()">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="#" class="nav__link" onclick="open_lecture()">
                        <i class='bx bxs-door-open nav__icon'></i>
                        <span class="nav__name">Open Lecture</span>
                    </a>

                    <!--<a href="#" class="nav__link" onclick="confirm_attendance()">
                        <i class='bx bxs-user-check nav__icon'></i>
                        <span class="nav__name">Confirm Attendance</span>
                    </a>-->

                    <a href="#" class="nav__link" onclick="teacher_reports()">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>
                    <a href="#" class="nav__link" onclick="teacher_profile()">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>
                    @elseif( Auth::user()->type == 'Student')
                    <!--student-->
                    <a href="#" class="nav__link active" onclick="student_dashboard()">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <!--<a href="#" class="nav__link" onclick="attend()">
                        <i class='bx bxs-calendar-check nav__icon'></i>
                        <span class="nav__name">Attend self</span>
                    </a>-->

                    <a href="#" class="nav__link" onclick="apply_excuse()">
                        <i class='bx bxs-calendar-plus nav__icon'></i>
                        <span class="nav__name">Apply Excuse</span>
                    </a>
                    <a href="#" class="nav__link" onclick="student_chat()">
                        <i class='bx bx-chat'></i>
                        <span class="nav__name">Chat</span>
                    </a>

                    <a href="#" class="nav__link" onclick="student_report()">
                        <i class='bx bx-book-content nav__icon'></i>
                        <span class="nav__name">Reports</span>
                    </a>

                    <a href="#" class="nav__link" onclick="student_pro()">
                        <i class='bx bxs-user-detail nav__icon'></i>
                        <span class="nav__name">Profile</span>
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
    <div id="content">

    @auth
        @if( Auth::user()->type == 'Admin')
            @include('admins.dashboard')
        @elseif(Auth::user()->type == 'Master')
            @include('admins.master')
        @elseif(Auth::user()->type == 'Dean')
            @include('dean.dashboard')
        @elseif(Auth::user()->type == 'Teacher')
            @include('teacher.dashboard')
        @elseif(Auth::user()->type == 'Student')
            @include('student.dashboard')
        @endif()
    @endauth
    </div>
    @auth
        @if(Auth::user()->type == 'Dean')
                <div class="modal fade" id="dean-note" tabindex="-1" role="dialog" aria-labelledby="deanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="deanModalLabel">Notifications</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="app">
                                    <studen-chat :auth="{{Auth::user()->userable_id}}"></studen-chat>
                                    <dean-excuse :auth="{{Auth::user()->userable_id}}"></dean-excuse>
                                    </div>
                                    @foreach ($notes as $note)
                                        <div class="notfy">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5>{{$note->data['sender']}} :</h5>
                                                <h6 id="title">{{$note->data['title']}}</h6>
                                                <p>{{$note->data['date']}}</p>
                                                <button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_dean_excuse()" class="text-white">View</a></button>
                                                <button class="btn btn-sm btn-warning mt-2"  onclick="set_as_read('{{$note->id}}')">Set as read</button>
                                            </div>
                                            <div class="col-6">
                                                <img src="images/excuse/{{$note->data['path']}}" width="100%" />
                                            </div>
                                        </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                    </div>
                </div>

        @elseif(Auth::user()->type == 'Admin')
            <div class="modal fade" id="admin-note" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="adminModalLabel">Notifications</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="app">
                                    <studen-chat :auth="{{Auth::user()->userable_id}}" ></studen-chat>
                                    <admin-excuse :auth="{{Auth::user()->userable_id}}"></admin-excuse>
                                    </div>
                                    @foreach ($notes as $note)
                                        <div class="notfy">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5>{{$note->data['sender']}}:</h5>
                                                <h6 id="title" class="lead pl-2">{{$note->data['title']}}</h6>
                                                <p class="small">{{$note->data['date']}}</p>
                                                <button class="btn btn-sm btn-success" data-dismiss="modal"><a onclick="go_to_admin_excuse()" class="text-white">View</a></button>
                                                <button class="btn btn-sm btn-warning mt-2"  onclick="set_as_read('{{$note->id}}')">Set as read</button>
                                            </div>
                                            <div class="col-6">
                                                <img src="images/excuse/{{$note->data['path']}}" width="90%" />
                                            </div>
                                        </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                    </div>
                </div>

        @elseif(Auth::user()->type == 'Teacher')
            <div class="modal fade" id="teacher-note" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="teacherModalLabel">Notifications</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($notes as $note)
                                        <div class="notfy">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6>{{$note->data['sender']}} :</h6>
                                                <h6 id="title">{{$note->data['title']}}</h6>
                                                <p>{{$note->data['date']}}</p>
                                                <button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_student_excuse()" class="text-white">View</a></button>
                                                <button class="btn btn-sm btn-warning mt-2"  onclick="set_as_read('{{$note->id}}')">Set as read</button>
                                            </div>
                                            <div class="col-6">
                                                <img src="images/excuse/{{$note->data['path']}}" width="100%" />
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                                    <div id="app">
                                    <dean-excuse :auth="{{Auth::user()->userable_id}}"></dean-excuse>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                    </div>
                </div>
        @elseif(Auth::user()->type == 'Master')
            <div class="modal fade" id="master-note" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="masterModalLabel">Notifications</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($notes as $note)
                                        <div class="notfy">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6>{{$note->data['sender']}} :</h6>
                                                <h6 id="title">{{$note->data['title']}}</h6>
                                                <p>{{$note->data['date']}}</p>
                                                <button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_student_excuse()" class="text-white">View</a></button>
                                                <button class="btn btn-sm btn-warning mt-2"  onclick="set_as_read('{{$note->id}}')">Set as read</button>
                                            </div>
                                            <div class="col-6">
                                                <img src="images/excuse/{{$note->data['path']}}" width="100%" />
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                                    <div id="app">
                                    <dean-excuse :auth="{{Auth::user()->userable_id}}"></dean-excuse>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                    </div>
                </div>
        @elseif(Auth::user()->type == 'Student')
            <div class="modal fade" id="student-note" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="studentModalLabel">Notifications</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="app">
                                    <student-attend-self :auth="{{Auth::user()->userable_id}}"></student-attend-self>
                                    <student-open-lecture :auth="{{Auth::user()->userable_id}}"></student-open-lecture>
                                    <student-excuse-accepted :auth="{{Auth::user()->userable_id}}"></student-excuse-accepted>
                                    <student-excuse-paid :auth="{{Auth::user()->userable_id}}"></student-excuse-paid>
                                    </div>
                                    @foreach ($notes as $note)
                                        <div class="notfy">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6>{{$note->data['sender']}} :</h6>
                                                <h6 id="title">{{$note->data['title']}}</h6>
                                                @if($note->data['status'] == 'Completed')
                                                    <h6 style="color:green;font-weight:bold">{{$note->data['status']}}</h6>
                                                @elseif($note->data['status'] == 'Not Paid')
                                                    <h6 style="color:red;font-weight:bold">{{$note->data['status']}}</h6>
                                                @elseif($note->data['status'] == 'Paid')
                                                    <h6 style="color:blue;font-weight:bold">{{$note->data['status']}}</h6>
                                                @endif
                                                <p class="small">{{$note->data['date']}}</p>
                                                <button class="btn btn-success btn-sm" data-dismiss="modal"><a href="#" onclick="go_to_student_excuse()" class="text-white">View</a></button>
                                                <button class="btn btn-sm btn-warning mt-2"  onclick="set_as_read('{{$note->id}}')">Set as read</button>
                                            </div>
                                            <div class="col-6">
                                                <img src="images/excuse/{{$note->data['path']}}" width="100%" />
                                            </div>
                                        </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                    </div>
                </div>

        @endif
    @endauth
    <!--student notification modal-->
<!-- Modal -->

<!--end app-->
    <script>
    /*admins links*/

        function dashboard(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/dashboard",
                type:"get",
                cache: false,
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }

        function admins(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/admins",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    console.log(data);
                    $("#content").html(data);

                }
            });
        }
        function students(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/students",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function teachers(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/teachers",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function courses(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/courses",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function groups(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/groups",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function semesters(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/semesters",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function attendances(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/attendances",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function excuses(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/excuses",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function go_to_admin_excuse(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/excuses",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function semester_course(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/semester-course",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function reports(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/reports",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function mprofile(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/master/profile",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);


                }
            });
        }
        function upgrade(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"admin/upgrade",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function mreports(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/mreports",
                type:"get",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        /*dean links*/
        function dean_dashboard(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/dean/dashboard",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function profile(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/dean/profile",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);
                }
            });
        }
        function accept_excuses(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"dean/excuses",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function go_to_dean_excuse(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"dean/excuses",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function dean_report(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/dean/reports",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        /*teacher links*/
        function teacher_dashboard(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/dashboard",
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);
                    console.log(data);

                }
            });
        }
        function open_lecture(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/lecture",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                datatype: "JSON",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);
                }
            });
        }
        function confirm_attendance(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/confirm",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function teacher_profile(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/profile",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:'',
                success:function(data){
                    $("#content").html(data);
                    console.log(data);

                }
            });
        }
        function teacher_reports(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/teacher/reports",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        /*student links*/
        function student_dashboard(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/dashboard",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function attend(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/attendance",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function apply_excuse(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/excuse",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function student_pro(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/profile",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function student_report(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/reports",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function student_chat(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/chat",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }

        function go_to_student_excuse(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/student/excuse",
                beforeSend:function(){
                    $("#loader").show()
                },
                complete:function(c){
                    $("#loader").hide(1000)
                },
                type:"get",
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function set_as_read(id){
            event.preventDefault();
            console.log(id)
            $.ajax({
                url:"/notification/read",
                type:"get",
                data:{'id':id},
                success:function(data){

                }
            });
        }
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

