<?php namespace App\Http\Controllers;

use DB;
use Request;

class AdminHistoryController extends Controller {

	public function getIndex()
	{
		$histories = DB::table('serverlogtb')->orderBy('ServerLogId','desc')->paginate(20);
		return view('admin.history.index')->with('histories', $histories);
	}

}
