<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') - Internet H&T</title>
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/animated.min.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	@yield('header')
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-movies">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url() }}">
					<img src="{{ asset('img/logo.png') }}" title="Logo">
				</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if(Auth::guest() || Auth::user()->UserType !== 3)
					<li><a href="{{ url() }}">Trang chủ</a></li>
					@if(env('EVENT_USER_DISPLAY')) <li><a href="{{ url('event') }}">Giải đấu</a></li> @endif
					<li><a href="{{ url('event/lucky-wheel') }}">Vòng quay may mắn</a></li>
					@else
					<li><a href="{{ url('admin/user') }}">Quản lí hội viên</a></li>
					<li><a href="{{ url('admin/history') }}">Nhật ký hệ thống</a></li>
					<li><a href="{{ url('admin/user/wheel') }}">Quay số</a></li>
					@endif
				</ul>
				<div class="col-sm-3 col-md-3">
			    <form class="navbar-form" role="search" action="{{ url('search') }}">
			        <div class="input-group">
			            <input type="text" class="form-control username" placeholder="Tìm bạn bè" name="q" value="{{ (Request::has('q')) ? Request::get('q') : '' }}">
			            <div class="input-group-btn">
			                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			            </div>
			        </div>
			        </form>
			    </div>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Đăng nhập</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tài khoản {{ Auth::user()->DisplayName }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								@if(Auth::user()->CType !== 0) <li><a href="{{ url('user/history-payment') }}">Lịch sử nạp tiền</a>@endif
								<li><a href="{{ url('user/change-password') }}">Đổi mật khẩu</a></li>
								<li class="divider"></li>
								<li><a href="{{ url('auth/logout') }}">Đăng xuất</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<footer id="footer">
		<div class="text-center">
			Copyrights &copy; {{ date('Y') }} H&T Internet.<br/>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
	@yield('footer')
</body>
</html>
