@extends('app')

@section('title', 'Nhật ký hệ thống')

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
				<div class="panel-heading">Nhật ký hệ thống
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>Tình trạng</th>
									<th>Thời gian</th>
									<th>Ghi chú</th>
								</tr>
								@foreach($histories as $history)
								<?php if($history->Status == 'Khởi động') $class = 'alert alert-warning'; else $class='' ?>
								<tr class="{{ isset($class) ? $class : '' }}">
									<td>{{ $history->Status }}</td>
									<td class="time">{{ $history->RecordDate }} {{ $history->RecordDate }}</td>
									<td>{{ $history->Note }}</td>
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
