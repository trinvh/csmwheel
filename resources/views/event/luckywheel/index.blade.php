@extends('app')

@section('title', 'Vòng quay may mắn')

@section('header')
<link rel="stylesheet" href="{{ asset('luckywheel/main.css') }}" type="text/css" />
<style>
.panel-heading {
    overflow: hidden;
    padding-top: 20px;
}
.btn-group {
    position: relative;
    top: -5px;
}
</style>
@endsection

@section('content')
<canvas id="confetti-world"></canvas>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Trò chơi Vòng quay may mắn
					<div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('event/lucky-wheel/payment') }}" class="btn btn-default">Xem lịch sử nạp tiền</a>
						<a href="{{ url('event/lucky-wheel/histories') }}" class="btn btn-default" >Lịch sử quay</a>
					</div>
				</div>
				<div class="panel-body clearfix">
				<div class="row">
					<div class="col-md-4">
					<h3><small>Xin chào, </small>{{ Auth::user()->DisplayName }}</h3>
						<hr>
						<h4 id="novacancy">Số lượt quay bạn đang có <span class="label label-success" id="user_can_wheel">{{ $user_can_wheel }}</span></h4>
						<hr>
						<div style="margin-top: 20px">
							<h4>Bạn có biết</h4>
							<ul class="list-group">
								<li class="list-group-item">Bạn dễ dàng nhận thêm 1 lượt quay mỗi 20.000đ nạp vào tài khoản.</li>
								@if(env('CSM_FREE_WHEEL_DAILY')) <li class="list-group-item text-danger">Mỗi ngày đăng nhập vào web bạn sẽ nhận được 1 lượt quay MIỄN PHÍ</li> @endif
								<li class="list-group-item">Lượt quay được tính theo mỗi lần nạp, không cộng dồn.</li>
								<li class="list-group-item">Cơ hội là như nhau, chỉ cần may mắn có thể lần quay nào bạn cũng sẽ được nhận giải ^^</li>
								<li class="list-group-item">Tích cực QWERTY, vận may sẽ đến...</li>
							</ul>
						</div>
					</div>
					<div class="col-md-8">
						<h3>Nhấn vào nút "Quay" <small>để bắt đầu</small></h3>
						<hr>
						<div class="clearfix">
							<div style="position: relative; padding-top: 20px; width: 450px" class="pull-left">
								<div id="arrow_spin"></div>
								<canvas class="the_canvas" id="myDrawingCanvas" width="450" height="450">								
									<p class="noCanvasMsg" align="center">Sorry, your browser doesn't support canvas.<br />Please try another.</p>
								</canvas>
								<button class="btn btn-primary" id="spin_button" onclick="startSpin();"><b class="glyphicon glyphicon-refresh"></b> QUAY</button>
							</div>
						</div>

					</div><!-- END COL MD 8 -->
					</div>
					<div class="row" style="margin-top: -150px; margin-bottom: -20px;height: 200px; background: url('{{ asset("img/bg-footertop.png") }}') no-repeat bottom center;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="popupMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
$('#spin_button').click(function() {
	$(this).prop('disabled', true);
});
var defined = {!! json_encode($prizes_defined) !!};
var prizes = new Array();
//Split parts
var angle = 360/defined.length;
var start = 0;
var end = angle;
for(i=0;i<defined.length;i++) {
	prizes[i] = {name: defined[i].amount.toString(), startAngle: start, endAngle: end};
	start += angle;
	end += angle;
}
</script>
<script type='text/javascript' src="{{ asset('luckywheel/winwheel_1.2.js') }}"></script>
<script type="text/javascript">
can_wheel = {{ $user_can_wheel }};
remain_wheel = {{ $user_can_wheel }};
var wheelImageName   = "{{ asset('luckywheel/wheel.png') }}";
var determinedGetUrl = "{{ url('event/lucky-wheel/prize') }}";
powerSelected(1);
begin();
</script>
<script type="text/javascript" src="{{ asset('js/jquery.novacancy.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confetti.js') }}"></script>
<script>
$('#novacancy').novacancy({
	'color': 'RED'
});
window.init();
</script>
@endsection
