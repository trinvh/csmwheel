<?php namespace App\Http\Controllers;

use DB;
use Request;

class AdminUserController extends Controller {

	public function getIndex()
	{
		Request::flash();
		$query = DB::table('usertb')
			->join('pricelisttb', 'usertb.UserType', '=', 'pricelisttb.PriceId')
			->leftJoin('trinvh_wheel', 'usertb.UserId','=','trinvh_wheel.userid')
			->select('trinvh_wheel.wheel','usertb.FirstName','usertb.UserId','usertb.UserName','usertb.RecordDate', 'usertb.Active','usertb.Status','usertb.LastLoginDate','usertb.MiddleName','usertb.MoneyUsed','usertb.RemainMoney','usertb.MoneyPaid','usertb.FreeMoney','usertb.MoneyTransfer','pricelisttb.PriceType')
			->where('pricelisttb.Type','<>',1)->where('pricelisttb.Type','<>',3);
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
				->paginate(20);
		//$users = DB::select("SELECT UserId, RecordDate, usertb.`Active`, Status, LastLoginDate, MiddleName, MoneyUsed, RemainMoney, MoneyPaid, FreeMoney, MoneyTransfer, PriceType FROM UserTb, pricelisttb WHERE Usertype = PriceID AND Type <> 1 AND Type <> 3 AND Status = 1  ORDER BY UserId DESC");
		return view('admin.user.index')->with('users', $users);
	}

	public function getWheel() {
		$total_wheel = DB::table('trinvh_wheel_history')->count();
		$total_win = DB::table('trinvh_wheel_history')->where('is_win','=', true)->count();
		//$total_wheel_paid = $total_wheel * 20000;
		$total_wheel_paid = DB::table('trinvh_wheel_payment')->where('wheel_count', '>', 0)->sum('amount');
		$total_win_prize = DB::table('trinvh_wheel_history')->sum('prize');
		$win_scale = number_format($total_win / $total_wheel * 100, 2);
		$win_prize_scale =number_format($total_win_prize / $total_wheel_paid * 100, 2);
		$histories = DB::table('trinvh_wheel_history')
			->join('usertb', 'usertb.UserId', '=', 'trinvh_wheel_history.userid')
			->select('usertb.MiddleName', 'trinvh_wheel_history.*', 'usertb.FirstName', 'usertb.UserName')
			->orderBy('trinvh_wheel_history.id','desc')
			->paginate(20);
		return view('admin.user.wheel')->withHistories($histories)
			->with('total_wheel', $total_wheel)
			->with('total_win', $total_win)
			->with('win_scale', $win_scale)
			->with('total_wheel_paid', $total_wheel_paid)
			->with('total_win_prize', $total_win_prize)
			->with('win_prize_scale', $win_prize_scale);
	}

	public function getWheelScale() {
		//DB::connection()->enableQueryLog();
		$users = DB::table('trinvh_wheel')
			->join('usertb', 'usertb.UserId','=','trinvh_wheel.userid')
			->leftJoin('trinvh_wheel_history', 'trinvh_wheel.userid', '=', 'trinvh_wheel_history.userid')
			->select('trinvh_wheel.*', 'usertb.UserName', 'usertb.FirstName', 'usertb.MiddleName', DB::raw('IFNULL(SUM(trinvh_wheel_history.prize), 0) as total_prize'))
			->groupBy('trinvh_wheel.userid')
			->orderBy('total_prize', 'desc')
			->paginate(20);
		//$queries = DB::getQueryLog();
		//return $queries;
		foreach($users as $user) {
			$user->total_paid = DB::table('trinvh_wheel_payment')->where('userid', $user->userid)->sum('amount');
			$user->was_wheel = DB::table('trinvh_wheel_history')->where('userid', $user->userid)->count();
			$user->scale = $user->total_prize / $user->total_paid * 100;
		}

		return view('admin.user.wheel_scale')
			->with('users', $users);
	}

}
