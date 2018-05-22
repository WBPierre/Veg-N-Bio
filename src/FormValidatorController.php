<?php
/**
 * @Author: Pierre
 * @Date:   2018-03-08 11:39:46
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-11 10:55:00
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
        Verify the integrity of a file
        @param $file
        @return Boolean
     */

    private function fileValidator(){
        $extensionUploaded = strtolower(substr(strrchr($_FILES['fileSend']['name'],'.'),1));

        if($extensionUploaded != 'png'){
            return false;
        }
        if(MAX_FILE_SIZE < $_FILES['fileSend']['size']){
            return false;
        }
        $name = PRODUCT_IMAGE_FOLDER;
        $short = strstr($_FILES['fileSend']['name'],'.',TRUE);
        $short .= uniqid();
        $short .= '.'.$extensionUploaded;
        $name .= $short;
        var_dump($name.' '.$short);
        if(move_uploaded_file($_FILES['fileSend']['tmp_name'],$name)){
            $this->data['file'] = $short;
            $this->valid = true;
            return true;
        }else{
            return false;
        }
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
            if(empty($value) && $value != "0"){
                break;
            }
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
                case 'file':
                    if($value == ""){
                        break;
                    }
                    if(!$this->fileValidator()){
                        return false;
                    }
                    break;
                case 'formName':
                    break;

                default:
                    htmlspecialchars($value);
                    $this->valid = true;
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
            if($key == 'id' || $key == 'vacationDay' || $key == 'vacationDayTotal' || $key == 'price' || $key == 'type'){
                $array[$key] = intval($value);
            }else{
                if($key == 'menuSelected'){
                    foreach($key as $value){
                        $array[$key][] = intval($value);
                    }
                }
                $array[$key] = $value;
            }
        }
        // die(var_dump($array));
        unset($array['formName']);
        return $array;

    }
}