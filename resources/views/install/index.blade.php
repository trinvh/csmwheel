@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Cài đặt CSM Web</div>

				<div class="panel-body">
					<p class="alert alert-warning">Thao tác cài đặt sẽ truy cập vào database nhưng không ảnh hưởng tới dữ liệu cũ.<br/>Khi cần Hủy / Cài đặt lại lượt quay của thành viên, vui lòng chạy lại 1 lần nữa</p>
					@if(Session::has('message'))
					<p class="alert alert-success">{{ Session::get('message') }}</p>
					@endif
					<form action="" method="POST" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="control-label col-sm-2">Dạng cài đặt</label>
							<div class="col-sm-4">
								<select name="type" class="form-control">
									<option value="new">Cài đặt mới</option>
									<option value="repair">Cập nhật sửa lỗi</option>
									<option value="remove">Trả về mặc định</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">Cài đặt</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
