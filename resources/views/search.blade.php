@extends('app')

@section('title', 'Tìm kiếm bạn bè')

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
				<div class="panel-heading">Tìm kiếm bạn bè
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						@if(isset($message))
						<p class="alert alert-warning">{{ $message }}</p>
						@endif
						@if(isset($users) && count($users) > 0)
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>Tài khoản</th>
									<th>Ngày tạo</th>
									<th>Lượt quay</th>
									<th>Tiền đã nạp</th>
									<th>Còn lại</th>
									<th>Đăng nhập cuối</th>
								</tr>
								@foreach($users as $user)
								<tr>
									<td>{!! str_replace(strtoupper(Request::get('q')), '<span style="background-color: yellow">'.strtoupper(Request::get('q')).'</span>',$user->MiddleName) !!}</td>
									<td>{{ $user->RecordDate }}</td>
									<td>{{ $user->wheel }}</td>
									<td>{{ $user->MoneyPaid }}</td>
									<td>{{ $user->RemainMoney }}</td>
									<td>{{ $user->LastLoginDate }}</td>
								</tr>
								@endforeach
							</table>
						</div>
						{!! $users->appends(['q'=> Request::get('q')])->render() !!}
						@else
						<p class="alert alert-danger">Không tìm thấy Hội viên nào có tên tài khoản như bạn muốn</p>
						@endif

					</div><!-- END COL MD 8 -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
