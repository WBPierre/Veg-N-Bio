<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-17 10:34:56
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-23 12:55:30
 */

/*
	LoginController handle the authentification and the verification of the data sent
 */

class LoginController{

	private $email;
	private $password;

	/*
		Construct the data in the class
		@param $data
	 */

	function __construct($data){
		$this->email = $data['email'];
		$this->password = $data['password'];
	}


	/*
		Verify the password
		return Boolean
	 */
	private function passwordVerify(){
		
	}

	public function logMe(){
		// TREAT PASSWORD !!!
		$db = new DataBaseController();
		$check = $db->fetch('SELECT id, employee, active, email, password FROM vnb_users WHERE email = '.$this->email);
		if(!$check){
			die('Error');
		}
		
	}
}