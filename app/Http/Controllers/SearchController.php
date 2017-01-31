<?php namespace App\Http\Controllers;

use Request;
use DB;

class SearchController extends Controller {

	public function getIndex()
	{
		if(Request::has('q')) {
			$query = DB::table('usertb')
				->join('pricelisttb', 'usertb.UserType', '=', 'pricelisttb.PriceId')
				->leftJoin('trinvh_wheel', 'usertb.UserId','=','trinvh_wheel.userid')
				->select('trinvh_wheel.wheel','usertb.UserId','usertb.UserName','usertb.RecordDate', 'usertb.Active','usertb.Status','usertb.LastLoginDate','usertb.MiddleName','usertb.MoneyUsed','usertb.RemainMoney','usertb.MoneyPaid','usertb.FreeMoney','usertb.MoneyTransfer','pricelisttb.PriceType')
				->where('CType','=',3)->where('pricelisttb.Type','<>',1)->where('pricelisttb.Type','<>',3)->where('MiddleName','LIKE',"%".Request::get('q')."%");
			if(Request::has('remainmoney')) {
				$query->where('usertb.RemainMoney','<', Request::get('remainmoney'));
			}
			if(Request::has('lastseen')) {
				$query->where('usertb.LastLoginDate','<=',Request::get('lastseen'));
			}
			if(Request::get('active') == 'on') {
				$query->where('usertb.Active','=',0);
			}
			if(Request::get('status') == 'on') {
				$query->where('usertb.Status','=',0);
			}
			$users = $query->orderBy('usertb.UserId','desc')
					->paginate(10);
			return view('search')->withUsers($users);
		} else {
			return view('search')->withMessage('Tìm kiếm tên Hội viên bằng Tên đăng nhập. Ví dụ bạn muốn tìm tài khoản SUPERMAN bạn có thể gõ SUPER hoặc MAN, hoặc đơn giản là RM');
		}
	}

}
