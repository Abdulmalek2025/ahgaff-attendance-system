<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{!! csrf_token() !!}}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transformations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boxicons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.4.1.js')}}" defer></script>
    <script src="{{ asset('js/boxicons.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>

</head>
<body id="body-pd">
    <div id="app">

        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
        <div class="d-flex">
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
                    @if( Auth::user()->type == 'admin')
                        <a href="#" class="nav__link active">
                        <i class='bx bxs-dashboard nav__icon' ></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="{{ route('admin')}}" class="nav__link">
                            <i class='bx bxs-user nav__icon' ></i>
                            <span class="nav__name">Admins</span>
                        </a>

                        <a href="{{ route('teacher')}}" class="nav__link">
                            <i class='bx bxs-user-pin nav__icon' ></i>
                            <span class="nav__name">Teachers</span>
                        </a>

                        <a href="{{ route('student') }}" class="nav__link">
                            <i class='bx bxs-user-check nav__icon'></i>
                            <span class="nav__name">Students</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-grid-alt nav__icon' ></i>
                            <span class="nav__name">Courses</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-group nav__icon' ></i>
                            <span class="nav__name">Groups</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-timer nav__icon' ></i>
                            <span class="nav__name">Semesters</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-calendar-check nav__icon' ></i>
                            <span class="nav__name">Attendance</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-calendar-exclamation nav__icon' ></i>
                            <span class="nav__name">Excuses</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-calendar nav__icon' ></i>
                            <span class="nav__name">Timetables</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-book-content nav__icon' ></i>
                            <span class="nav__name">Reports</span>
                        </a>
                        @elseif( Auth::user()->type == 'dean')
                        <!--Dean-->
                        <a href="#" class="nav__link">
                            <i class='bx bxs-user-detail nav__icon' ></i>
                            <span class="nav__name">Profile</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bxs-message-alt-check nav__icon' ></i>
                            <span class="nav__name">Accept Excuse</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-book-content nav__icon' ></i>
                            <span class="nav__name">Reports</span>
                        </a>
                        @elseif( Auth::user()->type == 'teacher')
                        <!--teacher-->
                        <a href="#" class="nav__link">
                            <i class='bx bxs-door-open nav__icon' ></i>
                            <span class="nav__name">Open Lecture</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bxs-user-check nav__icon' ></i>
                            <span class="nav__name">Confirm Attendance</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bxs-user-detail nav__icon' ></i>
                            <span class="nav__name">Profile</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-book-content nav__icon' ></i>
                            <span class="nav__name">Reports</span>
                        </a>
                        @elseif( Auth::user()->type == 'student')
                        <!--student-->
                        <a href="#" class="nav__link">
                            <i class='bx bxs-calendar-check nav__icon' ></i>
                            <span class="nav__name">Attend self</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bxs-calendar-plus nav__icon' ></i>
                            <span class="nav__name">Apply Excuse</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bxs-user-detail nav__icon' ></i>
                            <span class="nav__name">Profile</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-book-content nav__icon' ></i>
                            <span class="nav__name">Reports</span>
                        </a>
                        @endif
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="nav__link">
                            <i class='bx bx-log-out nav__icon' ></i>
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
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
