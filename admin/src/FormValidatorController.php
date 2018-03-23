<?php
/**
 * @Author: Pierre
 * @Date:   2018-03-08 11:39:46
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-22 10:23:55
 */

/**
 * Class FormValidatorController
 * Verify the integrity of a form
 */
class FormValidatorController{

	private $data;
	private $valid = false;

	/*
	* Create an array with all the datas
	* @param $array
	 */

	function __construct($array){
		$this->data = $array;
	}

	/*
		Verify an email
		@param $email
		@return Boolean
	 */

	private function emailValidator($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->valid = true;
			return true;
		}
		return false;
	}

	/*
		Verify a password
		@param $password
		@return Boolean
	*/
	
	private function passwordValidator($password){
		// if(strlen($password) < 8){
		// 	return false;
		// }
		$this->valid = true;
		return true;
	}


	/*
		Verify a phone number
		@param $string
		@return Boolean
	 */
	private function phoneValidator($number){
		if(strlen($number) < 10 ){
			return false;
		}
		if(!is_numeric(intval($number))){
			return false;
		}
			$this->valid = true;
			return true;
	}

	/*
		Verify a date
		@param $string
		@return boolean
	 */
	private function isDate($string){
		if(strlen($string) < 10){
			return false;
		}
		// CHECK STRTOTIME
		$this->valid = true;
		return true;
	}
	/*
		Verify all the data sent
		@return Boolean
	*/

	public function isValid(){
		
		foreach($this->data as $key => $value){
			switch($key){
				case 'email':
					if(!$this->emailValidator($value)){
						return false;
					}
					break;
				// case 'password':
				// 	if(!$this->passwordValidator($value)){
				// 		return false;
				// 	}
				// 	break;
				case 'phone':
					if(!$this->phoneValidator($value)){
						return false;
					}
					break;
				case 'birthdate':
					if(!$this->isDate($value)){
						return false;
					}
					break;
				case 'contract_start':
					if(!$this->isDate($value)){
						return false;
					}
					break;
				case 'contract_end':
					if(!$this->isDate($value)){
						return false;
					}
					break;
			}
		}
		return $this->valid;
	}

	/*
		Treat all the data before sending to database
		@return PHP Array
	 */
	public function treatData(){

		foreach($this->data as $key => $value){
			$this->data[$key] = htmlspecialchars($value);
			if($key == 'contractStart'){
				if(isset($this->data['contractEnd'])){
					$longStart = (time() - strtotime($this->data['contractStart'])) / 3600 / 24 /365;
					$longEnd = (time() - strtotime($this->data['contractEnd'])) / 3600 / 24 /365;
					$inter = $longStart - $longEnd;
					if($inter <= 0){
						return 0;
					}
				}
			}
			if($key == 'birthdate'){
				$age = (time() - strtotime($this->data['birthdate'])) / 3600 / 24 /365;
				if($age < 18 ){
					return 0;
				}
			}
			if($key != 'id'){
				if($key != 'formName'){
					$array[] = $value;
				}
			}
			
		}

			return $array;
		
	}
}