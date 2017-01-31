<?php namespace App\Http\Controllers;

use App\User;
use Request;
use Session;
use Auth;
use DB;

class LuckyWheelController extends Controller {

	public function prizes() {
		/*
		 * amount la so tien trung giai
		 * probability la ti le theo %
		*/
		$prizes = array(
			['amount' => 20000, 'probability' => 2],
			['amount' => 0, 'probability' => 17],
			['amount' => 5000, 'probability' => 4],
			['amount' => 0, 'probability' => 17],
			['amount' => 50000, 'probability' => 1],
			['amount' => 0, 'probability' => 17],
			['amount' => 5000, 'probability' => 4],
			['amount' => 0, 'probability' => 17],
			['amount' => 5000, 'probability' => 4],
			['amount' => 0, 'probability' => 17],
		);

		return $prizes;
	}

	public function getIndex() {
		$user = DB::table('trinvh_wheel')->where('userid',Auth::user()->UserId)->first();
		if($user) {
			if(date('Y-m-d',strtotime($user->last_login)) < date('Y-m-d')) {
				DB::table('trinvh_wheel')->where('userid',Auth::user()->UserId)->update(['last_login' => date('Y-m-d H:s:i')]);
				if(env('CSM_FREE_WHEEL_DAILY')) {
					if(Auth::user()->MoneyPaid > env('CSM_FREE_WHEEL_PAID_REQUIRED')) {
						DB::table('trinvh_wheel')->where('userid',Auth::user()->UserId)->increment('wheel');
						DB::table('trinvh_wheel_payment')->insert(['userid'=>Auth::user()->UserId,'amount'=>0,'wheel_count'=>1]);
					}
				}
			}
		}
		return view('event.luckywheel.index')->with('user_can_wheel', $this->get_user_can_wheel())->with('prizes_defined', $this->prizes());
	}

	public function getHistories() {
		$histories = DB::table('trinvh_wheel_history')->where('userid', Auth::user()->UserId)->orderBy('id', 'desc')->paginate(10);
		return view('event.luckywheel.histories')->with('user_can_wheel', $this->get_user_can_wheel())->with('histories', $histories);
	}

	public function getPayment() {
		$histories = DB::table('trinvh_wheel_payment')->where('userid', Auth::user()->UserId)->orderBy('id', 'desc')->paginate(10);
		return view('event.luckywheel.payment')->with('user_can_wheel', $this->get_user_can_wheel())->with('histories', $histories);
	}

	function get_user_can_wheel() {
		$userid = Auth::user()->UserId;
		$can = DB::table('trinvh_wheel')->where('userid',$userid)->first();
		
		return ($can) ? $can->wheel : 0;
	}

	function getPrize() {
		$user = Auth::user();
		$can_wheel = $this->get_user_can_wheel();
		$remain_wheel = ($can_wheel > 0) ? $can_wheel - 1 : 0;
		$prize = 1;//Khong trung
		$prize_amount = 0;
		$win = false;
		//Update remain wheel count
		if($can_wheel > 0) {
			DB::table('trinvh_wheel')->where('userid', $user->UserId)->decrement('wheel', 1);
			//Calc probility and prize
			$random = array();
			for($i = 0; $i < count($this->prizes()); $i++) {
				for($j = 0; $j < $this->prizes()[$i]['probability']; $j++) {
					$random[] = $i;
				}
			}
			shuffle($random);
			$prize = $random[0];
			$prize_amount = $this->prizes()[$prize]['amount'];
			$win = ($this->prizes()[$prize]['amount'] > 0);
			//Save result to database
			DB::table('trinvh_wheel_history')->insert(array(
				'userid' => $user->UserId,
				'is_win' => $win,
				'prize'  => $prize_amount,
			));
			//IMPORTANT
			//Update bảng usertb
			if($prize_amount > 0) {
				DB::table('usertb')->where('UserId', $user->UserId)->increment('RemainMoney', $prize_amount);
			}
		}
		return response()->json([
			'userid'	=> $user->UserId,
			'can_wheel'	=> $can_wheel,
			'remain_wheel'	=> $remain_wheel,
			'prize'		=> $prize,
			'prize_amount'	=> $prize_amount,
			'win'		=> $win
		]);
	}
}
