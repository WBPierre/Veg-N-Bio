<?php

/*
 * Class DashboardController
 * Handles all the display in the home page
 */

class DashboardController{

    function __construct()
    {

    }


    public function getArrayData(){
        $db = new DatabaseController();
        $request = $db->fetchAll('SELECT * FROm vnb_users WHERE active = 1 AND access_level = 0 ORDER BY id DESC LIMIT 3');
        $employees = $db->fetchAll('SELECT * FROm vnb_users WHERE active = 1 AND access_level >= 1 ORDER BY id DESC LIMIT 3');
        $array['user'] = $request;
        $array['employees'] = $employees;
        return $array;
    }


    public function getSaleData(){
        $db = new DatabaseController();
        $request = $db->fetchAll('SELECT COUNT(*) FROM vnb_order WHERE type = 0');
        $request2 = $db->fetchAll('SELECT COUNT(*) FROM vnb_order WHERE type = 1');
        $request3 = $db->fetchAll('SELECT COUNT(*) FROM vnb_order WHERE type = 2');
        $array['desk'] = $request['0']['0'];
        $array['internet'] = $request2['0']['0'];
        $array['mobile'] = $request3['0']['0'];
        $array['total'] = intval($request['0']['0']) + intval($request2['0']['0']) + intval($request3['0']['0']);
        return $array;
    }

    public function getStockData(){
        $db = new DatabaseController();
        $getStock = $db->fetchAll('SELECT * FROM vnb_restaurant_stock, vnb_product_component WHERE vnb_restaurant_stock.id_restaurant = '.$_SESSION['id_restaurant'].' AND vnb_restaurant_stock.id_component = vnb_product_component.id');
        $array = [];
        foreach($getStock as $key=>$value){
            $array[$key]['name'] = $value['name'];
            $array[$key]['quantity'] = intval($value['stock_value']);
        }
        return $array;
    }

    public function getLatestOrder(){
        $db = new DatabaseController();
        $getOrders = $db->fetchAll('SELECT * FROm vnb_order WHERE id_restaurant ='.$_SESSION['id_restaurant'].' ORDER BY id DESC LIMIT 6');
        foreach($getOrders as $key=>$value){
            $getOrders[$key]['date_inserted'] = substr($getOrders[$key]['date_inserted'], -8);
        }
        return $getOrders;
    }

    public static function getAllData(){
        $array['usersData'] = self::getArrayData();
        $array['userSales'] = self::getSaleData();
        $array['stockData'] = self::getStockData();
        $array['orderData'] = self::getLatestOrder();
        return $array;
    }


}