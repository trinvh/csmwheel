<?php namespace App\Http\Controllers;

use App\User;
use Request;
use Session;
use Auth;
use DB;

class EventController extends Controller {

	public function getIndex() {
		$from = env('EVENT_USER_PAID_FROM');
		$to = env('EVENT_USER_PAID_TO');
		$total_paid = DB::table('paymenttb')->where('UserId', Auth::user()->UserId)->where('PaymentType', 4)->where('VoucherDate','>=', $from)->where('VoucherDate','<=', $to)->sum('Amount');
		$user_valid = ($total_paid >= env('EVENT_USER_PAID_REQUIRED'));
		return view('event.index')->with('total_paid',$total_paid)->with('user_valid', $user_valid);
	}
}
