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


DROP TRIGGER IF EXISTS ddm.after_insert_payment;

DELIMITER $$
CREATE TRIGGER after_insert_payment
AFTER INSERT ON paymenttb
FOR EACH ROW
  BEGIN
    DECLARE number_wheel_count integer;
    SET @number_wheel_count := FLOOR(NEW.Amount / 20000);

    INSERT INTO trinvh_wheel_payment(userid, amount, wheel_count) VALUES (NEW.UserId, NEW.Amount, @number_wheel_count);
    IF NOT EXISTS(SELECT 1 FROM trinvh_wheel WHERE userid = NEW.UserId) THEN
      INSERT INTO trinvh_wheel(userid, wheel) VALUES (NEW.UserId, @number_wheel_count);
    ELSE
      UPDATE trinvh_wheel SET wheel = wheel + @number_wheel_count WHERE userid = NEW.UserId AND id <> 0;
    END IF;
  END;
$$
DELIMITER ;

DROP TRIGGER IF EXISTS ddm.before_delete_usertb;

DELIMITER $$
CREATE TRIGGER before_delete_usertb
BEFORE DELETE ON usertb
FOR EACH ROW
BEGIN
  DELETE FROM trinvh_wheel WHERE trinvh_wheel.userid = OLD.UserId AND trinvh_wheel.id <> 0;
  DELETE FROM trinvh_wheel_payment WHERE trinvh_wheel_payment.userid = OLD.UserId AND trinvh_wheel_payment.id <> 0;
  DELETE FROM trinvh_wheel_history WHERE trinvh_wheel_history.userid = OLD.UserId AND trinvh_wheel_history.id <> 0;
END;
$$
DELIMITER ;
