<?php namespace App\Http\Controllers;

use Request;
use DB;
use Auth;
use App\User;

class UserController extends Controller {

	public function getChangePassword()
	{
		return view('user.changepassword');
	}

	public function postChangePassword() {
		$old_password = Request::input('old_password');
		$password = Request::input('password');
		$confirm_password = Request::input('confirm_password');
		if($password !== $confirm_password) {
			return redirect()->back()->with('message','Mật khẩu mới không giống với xác nhận !');
		} else if($password == $old_password) {
			return redirect()->back()->with('message','Bạn không được sử dụng mật khẩu cũ !');
		} else if(!User::whereRaw("Password = old_password('".$old_password."') AND UserId = ".Auth::user()->UserId."")->first()) {
			return redirect()->back()->with('message', 'Mật khẩu cũ không đúng !');
		} else {
			DB::update('update usertb set Password = old_password(?) where UserId = ?', [$password, Auth::user()->UserId]);
			Auth::logout();
			return redirect('auth/login');
		}
	}

	public function getHistoryPayment() {
		$histories = DB::table('paymenttb')->where('paymenttb.UserId', Auth::user()->UserId)->where('PaymentType', 4)->join('usertb','paymenttb.StaffId','=','usertb.UserId')->orderBy('VoucherId', 'desc')->select('paymenttb.VoucherDate', 'paymenttb.VoucherTime','paymenttb.Amount','usertb.UserName')->paginate(10);
		return view('user.history_payment')->with('histories', $histories);
	}

	public function getHistoryTransfer() {
		$histories = DB::table('paymenttb')->where('paymenttb.UserId', Auth::user()->UserId)->where('PaymentType', 8)->join('usertb','paymenttb.StaffId','=','usertb.UserId')->orderBy('VoucherId', 'desc')->select('paymenttb.VoucherDate', 'paymenttb.VoucherTime','paymenttb.Amount','paymenttb.Note','usertb.UserName')->paginate(10);
		return view('user.history_transfer')->with('histories', $histories);
	}

	public function old_password($password) {
	  if ($password == '')
	    return '';
	  $nr = 1345345333;
	  $add = 7;
	  $nr2 = 0x12345671;
	  foreach(str_split($password) as $c) {
	    if ($c == ' ' or $c == "\t")
	      continue;
	    $tmp = ord($c);
	    $nr ^= ((($nr & 63) + $add) * $tmp) + ($nr << 8);
	    $nr2 += ($nr2 << 8) ^ $nr;
	    $add += $tmp;
	  }

	  if ($nr2 > PHP_INT_MAX)
	    $nr2 += PHP_INT_MAX + 1;

	  return sprintf("%x%x", $nr, $nr2);
	}
//Select user
//SELECT IF(YEAR(CURRENT_DATE)-YEAR(BirthDate) < 18, 1, 0), UserId, FirstName, MiddleName, LastName, UserName, MoneyUsed, RemainMoney, MoneyPaid, FreeMoney, MoneyTransfer, PriceType, CType, Debit, 0 as TotalDebit FROM UserTb, pricelisttb WHERE Usertype = PriceID AND Type <> 1 AND Type <> 3 AND Status = 1  ORDER BY UserId DESC LIMIT 0,200
}
