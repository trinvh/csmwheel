@extends('app')

@section('title', 'Đăng nhập vào CSM')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Đăng nhập vào CSM</div>
				<div class="panel-body">
					<div class="col-md-6">
						<h3><i class="glyphicon glyphicon-ok"></i> Vì sao nên tạo tài khoản <small>những lợi ích</small></h3>
						<hr>
						<ul>
							<li>Dễ dàng quản lý tài khoản, phân bố thời gian chơi game hợp lý</li>
							<li>Nhiều chương trình khuyến mãi, event chỉ dành riêng cho Hội viên</li>
						</ul>
					</div>

					<div class="col-md-6">
						<h4>Sử dụng tài khoản CSM <small>để đăng nhập</small></h4>
						<hr>
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@if (Session::has('message'))
							<div class="alert alert-danger">
								<strong>Đăng nhập không thành công !</strong>
								{{ Session::get('message') }}
							</div>
						@endif
						<form class="form-horizontal" role="form" method="POST" action="/auth/login">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-2 control-label">Username</label>
								<div class="col-md-6">
									<input style="text-transform: uppercase; font-weight: bold" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label">Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-2">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										Đăng nhập
									</button>
								</div>
							</div>
						</form>
						<div class="alert alert-danger"><strong>Chú ý: </strong>Nếu bạn không đăng nhập được tài khoản Hội viên trên web, vui lòng liên hệ với người Quản lý để
							để cập nhật tài khoản.</div>
					</div><!-- END COL MD 8 -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
