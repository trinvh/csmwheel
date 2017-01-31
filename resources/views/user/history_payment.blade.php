@extends('app')

@section('title', 'Lịch sử nạp tiền')

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
</style>
@endsection

@section('content')
<canvas id="confetti-world"></canvas>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Nhật ký Hội viên
					<div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('user/history-payment') }}" class="btn btn-default active">Nhật ký giao dịch</a>
						<a href="{{ url('user/history-transfer') }}" class="btn btn-default" >Chuyển / Nhận tiền</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<h3>Danh sách giao dịch <small>gần đây nhất</small></h3>
						<hr>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>Thời điểm nạp</th>
									<th>Số tiền</th>
									<th>Người nạp</th>
								</tr>
								@foreach($histories as $history)
								<tr>
									<td class="time">{{ $history->VoucherDate }} {{ $history->VoucherTime }}</td>
									<?php if($history->Amount < 10000) $label = 'default';
										else if($history->Amount < 50000) $label = 'primary';
										else if($history->Amount < 100000) $label = 'success';
										else if($history->Amount < 200000) $label = 'info';
										else if($history->Amount < 400000) $label = 'warning';
										else $label = 'danger'; ?>
									<td><span class="label label-{{ $label }}">{{ number_format($history->Amount) }}</span></td>
									<td>{{ $history->UserName }}</td>
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
