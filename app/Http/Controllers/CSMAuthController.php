<?php namespace App\Http\Controllers;

use App\User;
use Request;
use Session;
use Auth;
use DB;

class CSMAuthController extends Controller {
	public function __construct()
	{
		//$this->middleware('guest');
	}

	public function getLogin() {
		return view('auth.login');
	}

	public function postLogin() {
		$username = Request::input('username');
		$password = Request::input('password');
		$user = User::whereRaw("(((MiddleName = '".$username."' OR FirstName = '".$username."') AND CType = 3 AND Status = 1) OR (UserName = '".$username."')) AND Password = old_password('".$password."')")->first();
		if ($user)
		{
			if($user->Active == 0) {
				return redirect()->back()->with('message', 'Tài khoản bị KHÓA !');
			} else if($user->Status == 0) {
				return redirect()->back()->with('message', 'Tài khoản của bạn đã bị xóa, vui lòng liên hệ quản lý !');
			} else {
				Auth::loginUsingId($user->UserId);
				if($user->UserType == 3) {
					return redirect('admin/user');
				} else
					return redirect('/');
			} 
		} else {
			return redirect()->back()->with('message', 'Tên tài khoản hoặc mật khẩu không đúng');
		}
	}

	public function getLogout() {
		Auth::logout();
		return redirect('auth/login');
	}
}
