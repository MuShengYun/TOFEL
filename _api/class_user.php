<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-22
 * Time: 9:21
 */

include_once '../SQLC.php';

class Users {
    public $dbh;
    public $user_id = 0;
    public $user_name = '[已重置]';
    public function __construct($uid) {
        $this->user_id = $uid;
        $this->dbh = new SQLC();
        $rs = $this->dbh->query('SELECT `users`.uid, `users`.auth, `users`.reg_time, `user_info`.`nick`, `user_info`.`qq`, `user_info`.`school` FROM `users` left join `user_info` on `users`.uid = `user_info`.uid where `users`.uid = '.intval($uid));
		if (isset($rs[0])) {
			$this->user_qq = $rs[0]['qq'];
			$this->user_name = $rs[0]['nick'];
			$this->reg_time = $rs[0]['reg_time'];
			$this->school = $rs[0]['school'];
			$rs = $this->dbh->query('SELECT uid, expire FROM `user_token` where uid = '.intval($uid));
			if (isset($rs[0])) 
				$this->last_login = $rs[0]['expire'] - 86400;
			else
				$this->last_login = '未登录';
		} else {
			$this->user_qq = "".mt_rand(0, 39999);
			$this->user_qq .= sprintf("%05d", mt_rand(0, 99999));
			$this->user_name = '该用户不存在';
			$this->reg_time = time();
			$this->school = "克莱登大学";
			$this->last_login = time();
		}
    }
}