@extends('app')

@section('title', 'Quản lý Vòng quay may mắn')

@section('header')
<style>
.panel-heading {
    overflow: hidden;
    padding-top: 20px;
}
.btn-group {
    position: relative;
    top: -5px;
}
#filter-form {
	padding:10px;
	border-bottom: #EEE 1px solid;
	background: #F8F8F8;
	margin: -15px -30px 10px -30px;
}
</style>
@endsection

@section('content')
<canvas id="confetti-world"></canvas>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Quản lý Vòng quay may mắn
					<div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('admin/user/wheel') }}" class="btn btn-default active">Lượt quay gần đây</a>
						<a href="{{ url('admin/user/wheel-scale') }}" class="btn btn-default" >Tỉ lệ trúng / tài khoản</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="alert alert-info">
								<p>Tổng lượt đã quay : <span class="label label-success">{{ $total_wheel }}</span> - trúng <span class="label label-danger">{{ $total_win }}</span> lần. Tỉ lệ trúng <strong>{{ $win_scale }}%</strong></p>
								<p>Tổng tiền đã nạp : <span class="label label-success">{{ number_format($total_wheel_paid) }}</span> - trúng <span class="label label-danger">{{ number_format($total_win_prize) }}</span>. Tỉ lệ giải thưởng <strong>{{ $win_prize_scale }}%</strong></p>

							</div>
							<table class="table">
								<tr>
									<th>Tài khoản</th>
									<th>Giải thưởng</th>
									<th>Thời gian</th>
								</tr>
								@foreach($histories as $history)
								<tr>
									<td>{{ ($history->FirstName != '') ? $history->FirstName : $history->UserName }}</td>
									<td>@if($history->is_win) <span class="label label-success">{{ $history->prize }} @else <span class="label label-default">Không trúng</span> @endif</td>
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

@section('footer')

@endsection