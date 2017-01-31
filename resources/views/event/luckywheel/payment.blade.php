@extends('app')

@section('title', 'Lịch sử nạp tiền')

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
				<div class="panel-heading">Vòng quay may mắn - Xem lịch sử nạp tiền
					<div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('event/lucky-wheel/payment') }}" class="btn btn-default active">Xem lịch sử nạp tiền</a>
						<a href="{{ url('event/lucky-wheel/histories') }}" class="btn btn-default" >Lịch sử quay</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-4">
					<h3><small>Xin chào, </small>{{ Auth::user()->MiddleName }}</h3>
						<hr>
						<h4>Số lượt quay bạn đang có <span class="label label-success" id="user_can_wheel">{{ $user_can_wheel }}</span></h4>
						<hr>
						<div style="margin-top: 20px">
							<h4>Bạn có biết</h4>
							<ul class="list-group">
								<li class="list-group-item">Bạn dễ dàng nhận thêm 1 lượt quay mỗi 20.000đ nạp vào tài khoản.</li>
								<li class="list-group-item">Lượt quay được tính theo mỗi lần nạp, không cộng dồn.</li>
								<li class="list-group-item">Cơ hội là như nhau, chỉ cần may mắn có thể lần quay nào bạn cũng sẽ được nhận giải ^^</li>
								<li class="list-group-item">Tích cực QWERTY, vận may sẽ đến...</li>
							</ul>
						</div>
					</div>
					<div class="col-md-8">
						<h3>Lịch sử nạp tiền <small>trong Vòng quay may mắn</small></h3>
						<hr>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>Số tiền nạp</th>
									<th>Số lần quay được thưởng</th>
									<th>Thời gian</th>
								</tr>
								@foreach($histories as $history)
								<tr>
									<td>@if(env('CSM_FREE_WHEEL_DAILY') && $history->amount == 0) <span class="label label-success">Thưởng mỗi ngày</span> @else {{ $history->amount }} @endif</td>
									<td>{{ $history->wheel_count }}</td>
									<td class="time">{{ $history->create_at }}</td>
								</tr>
								@endforeach	
							</table>
							{!! $histories->render() !!}
						</div>

					</div><!-- END COL MD 8 -->
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
