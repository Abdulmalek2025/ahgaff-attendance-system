<!doctype html>
<html lang="en">
<!-- <div class="loader text-center">
    <img src="{{ asset('img/preview.gif') }}">
</div> -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="{{asset('/assets/js/jquery-3.4.1.js')}}"></script>
    <script src="{{asset('/assets/js/popper.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/fonts/all.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transformations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boxicons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/boxicons.js') }}" defer></script>
    <script src="{{asset('/assets/js/jquery-3.4.1.js')}}"></script>
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
                    <a href="#" class="nav__link active" onclick="dashboard()">
                        <i class='bx bxs-dashboard nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="#" class="nav__link" onclick="admins()">
                        <i class='bx bxs-user nav__icon'></i>
                        <span class="nav__name">Admins</span>
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

                    <a href="#" class="nav__link" onclick="semesters()">
                        <i class='bx bx-timer nav__icon'></i>
                        <span class="nav__name">Semesters</span>
                    </a>

                    <a href="#" class="nav__link" onclick="attendances()">
                        <i class='bx bx-calendar-check nav__icon'></i>
                        <span class="nav__name">Attendance</span>
                    </a>

                    <a href="#" class="nav__link" onclick="excuses()">
                        <i class='bx bx-calendar-exclamation nav__icon'></i>
                        <span class="nav__name">Excuses</span>
                    </a>

                    <a href="#" class="nav__link" onclick="timetables()">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Timetables</span>
                    </a>

                    <a href="#" class="nav__link" onclick=reports()>
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
    <div id="content">
    @include('admins.dashboard')
    </div>
    <script>
        function dashboard(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/dashboard",
                type:"get",
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
                url:"/admin/groups",
                type:"get",
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
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
        function timetables(){
            event.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"/admin/timetables",
                type:"get",
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
                data:{
                    CSRF_TOKEN
                },
                success:function(data){
                    $("#content").html(data);

                }
            });
        }
    </script>
</body>

</html>

