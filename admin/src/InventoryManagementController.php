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
        $inCourse = $db->fetchAll('SELECT * FROM vnb_offers, vnb_product_component, vnb_users, vnb_users_address WHERE vnb_users.id = vnb_users_address.id_user AND vnb_users.id = vnb_offers.id_producer AND vnb_offers.id_restaurant_ordering = '.intval($_SESSION['id_restaurant']).' AND vnb_offers.state = 1 AND vnb_offers.id_product_component = vnb_product_component.id AND vnb_users_address.name = "delivery" ');
        $available = $db->fetchAll('SELECT * FROM vnb_offers, vnb_product_component, vnb_users, vnb_users_address WHERE state = 0 AND vnb_users.id = vnb_users_address.id_user AND vnb_users.id = vnb_offers.id_producer AND vnb_offers.id_product_component = vnb_product_component.id AND vnb_users_address.name = "delivery" ');
        $stock['incourse'] = $inCourse;
        $stock['available'] = $available;
        return $stock;
    }

}