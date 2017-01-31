@extends('app')

@section('title', 'Thông tin giải đấu')

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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-movies">
				<div class="panel-heading">
					<h3 class="panel-title">{{ env('EVENT_NAME') }}</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<h3>Điều kiện</h3>
						<p>Bạn đang phải có tài khoản ở 1 trong các chi nhánh của Misa và phải nạp ít nhất <span class="label label-danger lead">{{ number_format(env('EVENT_USER_PAID_REQUIRED')) }} đ</span> trong khoảng thời gian từ <mark>{{ env('EVENT_USER_PAID_FROM') }}</mark> đến <mark>{{ env('EVENT_USER_PAID_TO') }}</mark></p>
						<div class="alert alert-{{ ($user_valid) ? 'info' : 'danger' }}">
							Bạn đã nạp <span class="label label-warning">{{ number_format($total_paid) }} đ</span> trong khoảng thời gian chương trình yêu cầu.
							<h3>Bạn {{ ($user_valid) ? 'đủ' : 'không đủ' }} điều kiện tham gia giải đấu.</h3>
							<p>Vui lòng ra quầy máy chủ để đăng ký nếu bạn muốn tham gia.</p>
						</div>
						<h3>Địa điểm thi đấu</h3>
						<p>Giải đấu tổ chức tại Misa 2 - 584 Lũy Bán Bích (đối diện ngã tư Vườn Lài).</p>
						<h3>Phương thức đăng ký</h3>
						<p>Bạn có thể đăng ký bằng cách gửi email vào địa chỉ misanet@yahoo.com hoặc đăng ký trực tiếp tại phòng máy bạn đang chơi:</p>
						<ul>
							<li>Misa 1: 16 Nguyễn Thái Bình, P.4, Q. Tân Bình.</li>
							<li>Misa 2: 584 Lũy Bán Bích, Q. Tân Phú (đối diện ngã tư Vườn Lài).</li>
						</ul>
						<p></p>
						<p>Để biết thêm chi tiết vui lòng liên hệ người quản lý.</p>
						<p></p>
						<p></p>
					</div><!-- END COL MD 8 -->
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
