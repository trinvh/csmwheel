@extends('app')

@section('title','Internet H&T Trang chủ')

@section('header')
<link rel="stylesheet" href="{{ asset('plugins/slick/slick.css') }}" />
<link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.css') }}" />
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-movies drop-shadow">
				<div class="panel-heading clearfix">
					<h3 class="panel-title pull-left">Home</h3>
					<div class="panel-subtitle pull-left" id="clock"></div>
				</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<h2><small>Chào bạn,</small> {{ Auth::user()->DisplayName }}</h2>
							<dl class="dl-horizontal">
							  <dt>Mã tài khoản</dt>
							  <dd>{{ Auth::user()->UserName }}</dd>
							  <dt>Ngày tạo</dt>
							  <dd>{{ Auth::user()->RecordDate }}</dd>
							</dl>
						</div>
						<div class="col-md-8">
							<div id="slogan-slider" style="margin: 0 20px">
								<div class="lead text-center">{{ env('NOTI_1') }}</div>
								<div class="lead text-center">{{ env('NOTI_2') }}</div>
								<div class="lead text-center">{{ env('NOTI_3') }}</div>
							</div>
							<p class="alert alert-danger" style="margin-bottom: 0">
								Bắt đầu từ tháng 3/2015, khi nạp tiền vào tài khoản bạn sẽ nhận được lượt chơi <strong>Vòng quay May mắn</strong> <span class="label label-danger">HOT - Mật khẩu WIFI: nethttn07</span>
							</p>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4">
							<h4>Liên kết hữu ích</h4>
							<ul class="list-group suggest-link">
								<li class="list-group-item"><i class="glyphicon glyphicon-hd-video"></i> <a href="http://daotao2.tnu.edu.vn/dhnl" target="_blank">Đăng ký học ĐHNL</a></li>
								<li class="list-group-item"><i class="glyphicon glyphicon-hd-video"></i> <a href="http://movies.hdviet.com" target="_blank">Xem phim HDViệt</a></li>
								<li class="list-group-item"><i class="glyphicon glyphicon-hd-video"></i> <a href="http://hayhaytv.vn" target="_blank">Xem phim Hayhaytv</a></li>
								<li class="list-group-item"><i class="glyphicon glyphicon-log-out"></i> <a href="http://vetv.vn" target="_blank">Kênh eSport VETV</a></li>
								<li class="list-group-item"><i class="glyphicon glyphicon-music"></i> <a href="http://chiasenhac.com" target="_blank">Chia sẻ nhạc</a></li>
								<li class="list-group-item"><i class="glyphicon glyphicon-text-color"></i> <a href="http://vnexpress.net" target="_blank">Đọc báo nhanh</a></li>
							</ul>
						</div>
						<div class="col-md-8">
							<div id="carousel-home" class="carousel slide" data-ride="carousel">
							  <!-- Indicators -->
							  <ol class="carousel-indicators">
							    <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
							    <li data-target="#carousel-home" data-slide-to="1"></li>
							  </ol>

							  <!-- Wrapper for slides -->
							  <div class="carousel-inner" role="listbox">
							    <div class="item active">
							      <img src="http://cssslider.com/sliders/demo-10/data1/images/2.jpg" alt="Misanet 1">
							      <div class="carousel-caption">
							      	<h3>Internet H&T - Nơi hội tụ của các game thủ^^</h3>
									Duy nhất tại Internet H&T xem phim tại HDViệt, Hayhaytv, Zing Video không quảng cáo và Full HD.
							      	Cổng trường ĐH Nông Lâm Thái Nguyên - ĐT: 0944 550 007 - 0968 550 007
							      </div>
							    </div>
							    

							  <!-- Controls -->
							  <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
							    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							    <span class="sr-only">Previous</span>
							  </a>
							  <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
							    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							    <span class="sr-only">Next</span>
							  </a>
							</div>
						</div><!-- !END RIGHT COLUMN -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="{{ asset('plugins/slick/slick.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#slogan-slider').slick({
		autoplay: true,
		arrows: true,
	});
});

function refrClock()
{
var d=new Date();
var s=d.getSeconds();
var m=d.getMinutes();
var h=d.getHours();
var day=d.getDay();
var date=d.getDate();
var month=d.getMonth();
var year=d.getFullYear();
var days=new Array("Chủ nhật","Thứ hai","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7");
var months=new Array("1","2","3","4","5","6","7","8","9","10","11","12");
if (s<10) {s="0" + s}
if (m<10) {m="0" + m}
if (h<10) {h="0" + h}
document.getElementById("clock").innerHTML= h + ":" + m + ":" + s + ", " + days[day] + " ngày " + date + "/" +months[month] + "/" + year;
setTimeout("refrClock()",1000);
}
refrClock();
</script>
@endsection
