<?php namespace App\Http\Controllers;

use File;
use DB;
use Request;

class InitController extends Controller {
	public function __construct()
	{
		//$this->middleware('guest');
	}

	public function install() {
		return view('install.index');
	}

	public function modifyDatabase() {
		if(Request::get('type') == 'new' || Request::get('type') == 'repair') {
			
			if(Request::get('type') == 'new') {
				//Create database
				
				DB::unprepared("
					DROP TABLE IF EXISTS `trinvh_wheel`;
					CREATE TABLE `trinvh_wheel` (
					  `id` int(11) NOT NULL auto_increment,
					  `userid` int(11) NOT NULL default '0',
					  `wheel` int(11) NOT NULL default '0',
					  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `trinvh_wheel_history`;
					CREATE TABLE `trinvh_wheel_history` (
					  `id` int(11) NOT NULL auto_increment,
					  `userid` int(11) NOT NULL default '0',
					  `is_win` tinyint(1) NOT NULL default '0',
					  `prize` decimal(9,0) NOT NULL default '0',
					  `create_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;


					DROP TABLE IF EXISTS `trinvh_wheel_payment`;

					CREATE TABLE `trinvh_wheel_payment` (
					  `id` int(11) NOT NULL auto_increment,
					  `userid` int(11) NOT NULL default '0',
					  `amount` decimal(9,0) NOT NULL default '0',
					  `wheel_count` int(11) NOT NULL default '0',
					  `create_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
				");
			}
			
			//Create triggers
			$result = DB::unprepared("
DROP TRIGGER IF EXISTS ddm.after_insert_payment;
CREATE TRIGGER after_insert_payment
AFTER INSERT ON paymenttb
FOR EACH ROW
  BEGIN
	DECLARE number_wheel_count integer;
	IF NEW.PaymentType = 4 AND (NEW.MachineName = '' OR NEW.MachineName IS null) THEN
		IF NEW.Amount > 0 THEN
			SET @number_wheel_count := FLOOR(NEW.Amount / 20000);
		ELSE
			SET @number_wheel_count := CEIL(NEW.Amount / 20000);
		END IF;
		INSERT INTO trinvh_wheel_payment(userid, amount, wheel_count) VALUES (NEW.UserId, NEW.Amount, @number_wheel_count);
		IF NOT EXISTS(SELECT 1 FROM trinvh_wheel WHERE userid = NEW.UserId) THEN
		  INSERT INTO trinvh_wheel(userid, wheel) VALUES (NEW.UserId, @number_wheel_count);
		ELSE
		  UPDATE trinvh_wheel SET wheel = wheel + @number_wheel_count WHERE userid = NEW.UserId AND id <> 0;
		END IF;
	END IF;
  END;
DROP TRIGGER IF EXISTS ddm.after_delete_usertb;
CREATE TRIGGER after_delete_usertb
AFTER DELETE ON usertb
FOR EACH ROW
BEGIN
  DELETE FROM trinvh_wheel WHERE trinvh_wheel.userid = OLD.UserId AND trinvh_wheel.id <> 0;
  DELETE FROM trinvh_wheel_payment WHERE trinvh_wheel_payment.userid = OLD.UserId AND trinvh_wheel_payment.id <> 0;
  DELETE FROM trinvh_wheel_history WHERE trinvh_wheel_history.userid = OLD.UserId AND trinvh_wheel_history.id <> 0;
END;
			");

			return redirect()->back()->with('message', 'Cài đặt thành công !');
		} else {
			DB::unprepared("
				DROP TABLE IF EXISTS `trinvh_wheel`;
				DROP TABLE IF EXISTS `trinvh_wheel_history`;
				DROP TABLE IF EXISTS `trinvh_wheel_payment`;
				DROP TRIGGER IF EXISTS ddm.after_insert_payment;
				DROP TRIGGER IF EXISTS ddm.before_delete_usertb;
			");
			return redirect()->back()->with('message', 'Gỡ bỏ cài đặt thành công !');
		}
	}

	public function readSqlFile() {
		$sql = File::get('initialization.sql');
		return $sql;
	}

}
