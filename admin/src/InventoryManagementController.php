<?php

/**
 * @Author: Pierre
 * @Date:   2018-04-09 10:24:29
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-16 09:21:31
 */

/*
	Class InventoryManagement
	This class handle all the stock management
 */

class InventoryManagementController{


    /*
        Nothing for now
     */

    function __construct(){

    }

    /*
        getAllOffers returns an array with all the offers registered
        @return PHP Array
     */
    public function getAllOffers(){
        $db = new DatabaseController();
        $offers = $db->fetchAll('SELECT * FROM vnb_announce WHERE state < 2');
        foreach($offers as $key=>$value){
            $product = $db->fetchAll('SELECT vnb_offers.* FROM vnb_offers,vnb_announce_products WHERE vnb_announce_products.id_announce = '.$value['id'].' AND vnb_offers.id = vnb_announce_products.id_products');
            $producer = $db->fetch('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => intval($value['id_producer']) ]);
            if(count($product)  != 0){
                $offers[$key]['products'] = $product;
                $offers[$key]['producer'] = $producer;
            }else{
                unset($offers[$key]);
            }
        }
        return $offers;
    }

}