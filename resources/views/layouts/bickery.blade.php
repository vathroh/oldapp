<!DOCTYPE html>
<html>
	<head>
		<title>OSP-1</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
		<link href="{{ asset('blog/css/layout.css') }}" rel="stylesheet" type="text/css" media="all">
	</head>
	<body id="top">		
		@include('layouts.navbar.bickery')
		@yield('page_title')
		@yield('content')
		
		<div class="wrapper row4 bgded overlay" style="background-color: black">
			<footer id="footer" class="hoc clear"> 
				<img class = "heading" src = "{{ asset('logo_kotaku_pure.png') }}" style = "width: 200px;">
				<h3 class="heading">OSP-1 JAWA TENGAH-1</h3>
				<nav>
					<ul class="nospace inline pushright uppercase">
						<li><a href="index.html"><i class="fa fa-lg fa-home"></i></a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="#">Wilayah Dampingan</a></li>
					</ul>
				</nav>
			<ul class="faico clear">
				<li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
				<li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
				<li><a class="faicon-dribble" href="#"><i class="fa fa-instagram"></i></a></li>
				<li><a class="faicon-linkedin" href="#"><i class="fa fa-youtube"></i></a></li>
			</ul>
		  </footer>
		</div>
		<div class="wrapper row5">
			<div id="copyright" class="hoc clear" style = "text-align: center;"> 
				<p>Copyright &copy; 2020 - <a href="http://osp1.my.id">OSP-1 JAWA TENGAH 1</a></p>
			</div>
		</div>				

		<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
		
		<!-- JAVASCRIPTS -->
		<script src="{{ asset('blog/js/jquery.min.js') }}"></script>
		<script src="{{ asset('blog/js/jquery.backtotop.js') }}"></script>
		<script src="{{ asset('blog/js/jquery.mobilemenu.js') }}"></script>
		<script src="{{ asset('blog/js/jquery.flexslider-min.js') }}"></script>
	</body>
</html>
