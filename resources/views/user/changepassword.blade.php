@extends('app')

@section('title', 'Đổi mật khẩu')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Đổi mật khẩu CSM</div>
				<div class="panel-body">
					<div class="col-md-6">
					<h3>Vì sao nên tạo tài khoản <small>những lợi ích</small></h3>
						<hr>
						<ul>
							<li>Dễ dàng quản lý tài khoản, phân bố thời gian chơi game hợp lý</li>
							<li>Nhiều chương trình khuyến mãi, event chỉ dành riêng cho Hội viên</li>
							<li>Gói chơi đêm cực rẻ</li>
						</ul>
					</div>
					<div class="col-md-6">
						<h3>Đổi mật khẩu <small>hội viên</small></h3>
						<hr>
						@if (Session::has('message'))
							<div class="alert alert-danger">
								{{ Session::get('message') }}
							</div>
						@endif
						<form class="form-horizontal" role="form" method="POST" action="">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Mật khẩu cũ</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="old_password" autofocus required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Mật khẩu mới</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label">Xác nhận mật khẩu mới</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="confirm_password" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										Đổi mật khẩu
									</button>
								</div>
							</div>
						</form>
					</div><!-- END COL MD 8 -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
