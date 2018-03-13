<?php
/**
 * @Author: Pierre
 * @Date:   2018-03-08 11:39:46
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-09 11:11:34
 */

/**
 * Class FormValidatorController
 * Permet de vérifier l'intégrité d'un formulaire
 */
class FormValidatorController{

	private $data;
	private $valid = false;

	/*
	* Construit le tableau en private dans la classe
	* @param $array
	 */

	function __construct($array){
		$this->data = $array;
	}

	/*
		Verification du champ email
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
		Verification du champ password
		@param $password
		@return Boolean
	*/
	
	private function passwordValidator($password){
		$this->valid = true;
		return true;
	}

	/*
		Verification de la validité des champs transmis
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
				case 'password':
					if(!$this->passwordValidator($value)){
						return false;
					}
					break;
			}
		}
		return $this->valid;
	}
}