<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF TOKEN -->
    <meta name="csrdf-token" content="{{ csrf_token() }}">
    <title>Kotaku OSP-1</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/blog/admin.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="wrapper">
            <div class="side-menu">
                <div class="logo">
                    <h1 class="ch-1">Kotaku OSP-1</h1>
                    <p class="cp">Blog Panel | Dashboard</p>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <DashboardMenu></DashboardMenu>

            <div class="main-content">
                <div class="top-menu">
                    <a href="#" id="show-menu"><i class="fa fa-bars" aria-hidden="true"></i></a>
                    <div class="search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" class="src" placeholder="search ... ">
                    </div>
                    <div class="uactions">
                        <div class="admin-username">
                            <p>Welcome, {{ Auth::user()->name  }} </p>
                        </div>
                        <div class="admin-logout">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ _('Logout') }} </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" style="display:none"> @csrf </form>
                    </div>
                </div>
            </div>

            <div class="main-section">
                <!-- Jumbotron -->
                <router-view></router-view>
                <!-- End Jumbotron -->
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
</body>

</html>