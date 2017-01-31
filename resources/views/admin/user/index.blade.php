@extends('app')

@section('title', 'Quản lý Hội viên')

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
				<div class="panel-heading">Quản lý hội viên
					<!-- <div class="btn-group btn-group-sm pull-right">
						<a href="{{ url('user/history-payment') }}" class="btn btn-default active">Nhật ký giao dịch</a>
						<a href="{{ url('user/history-transfer') }}" class="btn btn-default" >Chuyển / Nhận tiền</a>
					</div> -->
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form class="form-inline" id="filter-form">
							<input type="hidden" name="page" value="{{ $users->currentPage() }}">
							<div class="form-group">
								<label>Tiền còn lại ít hơn</label>
								<input name="remainmoney" type="text" value="{{ old('remainmoney') }}" class="form-control input-sm">
							</div>
							<div class="form-group">
								<label>Đăng nhập lần cuối</label>
								<input name="lastseen" type="text" value="{{ old('lastseen') }}" class="form-control input-sm">
							</div>
							<div class="checkbox">
								<label>
									<input name="active" type="checkbox" class="form-control input-sm" {{ (old('active') == 'on') ? 'checked="checked"' : '' }}>
									Bị khóa
								</label>								
							</div>
							<div class="checkbox">
								<label>
									<input name="status" type="checkbox" class="form-control input-sm" {{ (old('status') == 'on') ? 'checked="checked"' : '' }}>
									Đã xóa
								</label>								
							</div>
							<button type="submit" class="btn btn-info">Tìm kiếm</button>
							<a href="#" id="clear_filter">Reset</a>
						</form>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>ID</th>
									<th>Tài khoản</th>
									<th>Ngày tạo</th>
									<th>Nhóm</th>
									<th>Lượt quay</th>
									<th>Tiền đã nạp</th>
									<th>Còn lại</th>
									<th>Đã tặng</th>
									<th>Bị khóa</th>
									<th>Đăng nhập cuối</th>
								</tr>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->UserId }}</td>
									<td>{{ ($user->FirstName !== '') ? $user->FirstName : $user->UserName }}</th>
									<td>{{ $user->RecordDate }}</td>
									<td>{{ $user->PriceType }}</td>
									<td>{{ $user->wheel }}</td>
									<td>{{ number_format($user->MoneyPaid) }}</td>
									<td>{{ number_format($user->RemainMoney) }}</td>
									<td>{{ number_format($user->FreeMoney) }}</td>
									<td>@if($user->Active == 1) <span class="label label-default">Không</span> @else <span class="label label-danger">Khóa</span> @endif</td>
									<td class="time">{{ $user->LastLoginDate }}</td>
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
<script>
$('#clear_filter').click(function(e) {
	e.preventDefault();
	$(this).parent().find('input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
	$(this).parent().submit();
});
</script>
@endsection