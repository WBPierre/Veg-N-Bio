<?php


/*
 * Class UserController
 * Handles the retrieve of all the data from a User
 */
Class UserController{

    public function __construct(){

    }

    /*
     * getUserData
     * Handles all the data from a User
     * @return PHP array
     */
    public static function getUserData(){
        $db = new DatabaseController();
        $array = $db->fetchAll('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => $_SESSION['id']]);
        $array['orders'] = $db->fetchAll('SELECT * FROM vnb_order WHERE id_user = :id',[ 'id' => $_SESSION['id']]);
        foreach($array['orders'] as $key=>$value){
            $array['orders'][$key]['date_inserted'] = date( "d/m/Y - H:i:s", strtotime($value['date_inserted']));
        }
        $array['addresses']=$db->fetchAll('SELECT * FROM vnb_users_address WHERE id_user = :id',[ 'id' => $_SESSION['id']]);
        return $array;
    }
}