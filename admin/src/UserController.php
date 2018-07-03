<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-13 14:50:08
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-03 11:57:23
 */
/*
	Class that handle all treatment needed on the employees
 */
class UserController{

    private $userArray = array();

    /*
        Nothing for now
     */
    function __construct(){

    }

    /*
        getAllEmployees allow to get all the data of the employees
        @return PHP Array
     */
    public function getAllUsers(){
        $i = 0;
        $db = new DatabaseController();
        $data = $db->fetchAll('SELECT * FROM vnb_users WHERE access_level = 0');
        foreach($data as $value){
            $this->$userArray[$i]['id'] = $value['id'];
            $this->$userArray[$i]['firstname'] = $value['firstname'];
            $this->$userArray[$i]['name'] = $value['name'];
            $this->$userArray[$i]['gender'] = $value['gender'];
            $this->$userArray[$i]['email'] = $value['email'];
            $this->$userArray[$i]['birthdate'] = $value['birthdate'];
            $this->$userArray[$i]['phone'] = $value['phone'];
            $this->$userArray[$i]['active'] = $value['active'];
            $i++;
        }
        return $this->$userArray;
    }

    /*
    addEmployee allow to add employee to the database
    @return Boolean
 */
    public function addEmployee($array){
        $db = new DatabaseController();
        $data = $db->insert('INSERT INTO vnb_users(name, firstname, gender, email, birthdate, phone, active, employee) VALUES ('.$array['name'].','.$array['firstname'].','.$array['gender'].','.$array['email'].','.$array['birthdate'].','.$array['phone'].','.$array['active'].','.$array['access_level'].')');
        // RECUPERER LAST ID
        $contract = $db->insert('INSERT INTO vnb_users(id_employee, job, contratc_start, contract_end, vacation_day_total) VALUES ('.$array['id_employee'].','.$array['job'].','.$array['contract_start'].','.$array['contract_end'].','.$array['vacation_day_total'].')');
        if($data && $contract){
            return true;
        }
    }
}