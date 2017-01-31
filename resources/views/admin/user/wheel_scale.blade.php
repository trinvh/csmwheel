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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Quản lý Vòng quay may mắn
					<div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('admin/user/wheel') }}" class="btn btn-default">Lượt quay gần đây</a>
						<a href="{{ url('admin/user/wheel-scale') }}" class="btn btn-default active" >Tỉ lệ trúng / tài khoản</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>ID</th>
									<th>Tài khoản</th>
									<th>Tiền nạp</th>
									<th>Còn lại</th>
									<th>Đã quay</th>
									<th>Đã trúng</th>
									<th>Tỉ lệ</th>
								</tr>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->userid }}</td>
									<td>@if($user->FirstName != '') {{ $user->FirstName }} @else {{ $user->UserName }} @endif</td>
									<td>{{ number_format($user->total_paid) }}</td>
									<td>{{ $user->wheel }}</td>
									<td>{{ $user->was_wheel }}</td>
									<td>{{ number_format($user->total_prize) }}</td>
									<td>{{ number_format($user->scale, 2) }}</td>
								</tr>
								@endforeach	
							</table>
							{!! $users->render() !!}
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