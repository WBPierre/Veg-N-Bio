<?php

/**
 * @Author: Pierre
 * @Date:   2018-04-09 10:24:29
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-16 09:21:31
 */

/*
	Class ProductController
	This class handle all the product management
 */

class ProductController{


	/*
		Nothing for now
	 */
	
	function __construct(){

	}


	/*
		getAllProducts returns an array with all the products registered
		@param $menu 
		@param $active
		@return PHP Array
	 */
	public function getAllProducts($menu = NULL, $active = NULL){
		$db = new DatabaseController();
		$request = "SELECT * FROM vnb_restaurant_product";
		if($menu != NULL){
			$params['menu_composit'] = $menu;
			$request .= " WHERE menu_composit = :menu_composit";
		}
		if($active != NULL){
			$params['active'] = $active;
			if($menu != NULL){
				$request .= " AND active = :active";
			}else{
				$request .= " WHERE active = :active";
			}
		}
		$data = $db->fetchAll($request,$params);
		for($i = 0; $i<count($data);$i++){
			$compo = $db->fetchAll("SELECT * FROM vnb_restaurant_product_composition WHERE id_product = :id",['id' => $data[$i]['id'] ]);
			$data[$i]['compo'] = $compo;
			$array[$data[$i]['type']][]= $data[$i];
		}
		ksort($array);
		return $array;
	}


	/*
		getAllMenus returns an array with all the menus registered
		@param $format
		@return PHP Array
	 */
	public function getAllMenus($format){
		$db = new DatabaseController();
		$request = "SELECT * FROM vnb_restaurant_menu_lang,vnb_restaurant_menu WHERE vnb_restaurant_menu.id_restaurant = :id_restaurant AND vnb_restaurant_menu_lang.lang = :lang AND vnb_restaurant_menu.id = vnb_restaurant_menu_lang.id_menu";
		$array = $db->fetchAll($request,[ 'id_restaurant' => 1, 'lang' => $_SESSION['lang'] ]);
		if($format){
			foreach($array as $key=>$value){
				$treated[$key]['id'] = $value['id_menu'];
				$treated[$key]['name'] = $value['name'];
				$treated[$key]['type'] = $value['type'];
				$treated[$key]['price'] = $value['price'];
			}
			return $treated;
		}else{
			return $array;
		}
		
		
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


    /*
     * getStock returns an array with all the current stock of the restaurant
     * @return PHP Array
     */

    public static function getStock(){
        $db = new DatabaseController();
        $array = $db->fetchAll('SELECT vnb_restaurant_stock.stock_value, vnb_product_component.name FROM vnb_restaurant_stock, vnb_product_component 
                                WHERE vnb_restaurant_stock.id_restaurant = '.$_SESSION['id_restaurant'].' AND vnb_restaurant_stock.id_component = vnb_product_component.id');
        return $array;
    }

    /*
     * getComposant returns an Array with all the components available
     * @return PHP Array
     */
    public function getComposant(){
        $db = new DatabaseController();
        $array = $db->fetchAll('SELECT * FROM vnb_product_component');
        return $array;
    }

}