<?php


class OrderController{

    function __construct(){

    }


    public function getMenuOnProduct(){
        $array = $this->getAllMenus(true);
        $db = new DatabaseController();
        $request = $db->fetchAll("SELECT * FROM vnb_restaurant_menu_product");
        foreach($request as $key=>$value){
            foreach($array as $menuKey => $menuValue){
                if($value['id_menu'] == $menuValue['id']){
                    $array[$key]['id_product'] = $value['id_product'];
                }
            }
        }
        return $array;
    }

}