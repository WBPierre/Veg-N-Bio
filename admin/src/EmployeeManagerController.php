<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-13 14:50:08
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-14 21:01:52
 */
/*
	Class that handle all treatment needed on the employees
 */
class EmployeeManagerController{

	private $employeesArray = array();

	/*
		Nothing for now
	 */
	function __construct(){
		
	}

	/*
		getAllEmployees allow to get all the data of the employees
		@return PHP Array
	 */
	public function getAllEmployees(){
		$i = 0;
		$db = new DatabaseController();
		$data = $db->fetchAll('SELECT * FROM vnb_users WHERE employee = 1 AND active = 1');
		$contracts = $db->fetchAll('SELECT * FROM vnb_contract');
		foreach($data as $value){
			foreach($contracts as $text){
				if($text['id_employee'] == $value['id']){
					$this->employeesArray[$i]['id'] = $value['id'];
					$this->employeesArray[$i]['firstname'] = $value['firstname'];
					$this->employeesArray[$i]['name'] = $value['name'];
					$this->employeesArray[$i]['gender'] = $value['gender'];
					$this->employeesArray[$i]['email'] = $value['email'];
					$this->employeesArray[$i]['birthdate'] = $value['birthdate'];
					$this->employeesArray[$i]['phone'] = $value['phone'];
					$this->employeesArray[$i]['active'] = $value['active'];
					$this->employeesArray[$i]['job'] = $text['job'];
					$this->employeesArray[$i]['contract_start'] = $text['contract_start'];
					$this->employeesArray[$i]['contract_end'] = $text['contract_end'];
					$this->employeesArray[$i]['vacation_day'] = $text['vacation_day'];
					$this->employeesArray[$i]['vacation_day_total'] = $text['vacation_day_total'];
					$this->employeesArray[$i]['contract_last'] = (strtotime($text['contract_end']) - strtotime($text['contract_start']))/86400;
					$this->employeesArray[$i]['contractType'] = 'CDI';
				}
			}
			$i++;
		}
		return $this->employeesArray;
	}
}