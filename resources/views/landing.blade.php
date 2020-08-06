<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>KOTAKU OSP-1 Jateng-1</title>
	<link rel="stylesheet" href="css/landingstyle.css">
	<!-- 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<script src="https://kit.fontawesome.com/e3a45180d4.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="homepage">
		<header>
			<div class="logo">
				<img src="img/Logotype_kotakupu_png.png" style="height: 40px" alt="">
				<ul>
				</ul>
			</div>
			<div class="menu">
				<ul>
					@if (Route::has('login'))
        <div class="top-right links">
            @auth
            <li>
            <a href="{{ url('/home') }}">Home</a></li>
            @else
            <li><a href="{{ route('login') }}">Login</a></li>
            @if (Route::has('register'))
            <li><a href="{{ route('register') }}">Register</a></li>
            @endif
            @endauth
        </div>
        @endif
				</ul>
			</div>
		</header>
		<div class="title">
			<h1>KOTAKU</h1>
			<h3>OSP-1 JAWA TENGAH-1</h3>
		</div>
	</div>
</body>
</html>