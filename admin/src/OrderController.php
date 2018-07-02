<?php


/*
 * Class OrderController
 * Handles the retrieve of all the data from an Order
 */
Class OrderController{

    public function __construct(){

    }

    /*
     * getOrderDetail
     * Handles all the data from an Order
     * @return PHP array
     */
    public static function getOrderDetail($id = false){
        $db = new DatabaseController();
        $data = $db->fetchAll('SELECT * FROM vnb_order ORDER BY id DESC LIMIT 1');
        $data['0']['date_inserted'] = date("d-m-Y",strtotime($data['0']['date_inserted']));
        $infoMenu = $db->fetchAll('SELECT * FROM vnb_order_menu WHERE id_order = '.$data['0']['id']);
        if($infoMenu != false){
            $i =0;
            foreach($infoMenu as $key=>$value){
                $menuName = $db->fetchAll('SELECT vnb_restaurant_menu.price,vnb_restaurant_menu_lang.name  FROM vnb_restaurant_menu,vnb_restaurant_menu_lang WHERE vnb_restaurant_menu_lang.lang = "'.$_SESSION['lang'].'" AND vnb_restaurant_menu.id = '.intval($infoMenu[$i]['id_menu']).' AND vnb_restaurant_menu_lang.id_menu = '.intval($infoMenu[$i]['id_menu']));
                $data['menu'][$i]['info'] = $menuName['0'];
                $data['menu'][$i]['info']['name'] = self::suppr_accents($menuName['0']['name']);
                $data['menu'][$i]['info']['quantity'] = $value['quantity'];
                $menuProduct = $db->fetchAll('SELECT id_product FROM vnb_order_menu_product WHERE id_order_menu ='.$infoMenu['0']['id']);
                $j = 0;
                foreach($menuProduct as $mKey=>$mValue){
                    $product = $db->fetchAll('SELECT * FROM vnb_restaurant_product WHERE id = '.intval($mValue['id_product']));
                    $data['menu'][$i]['product'][$j]['name'] = self::suppr_accents($product['0']['name']);
                    if($id){
                        $data['menu'][$i]['product'][$j]['id'] = intval($product['0']['id']);
                    }
                    $j++;
                }
                $i++;
            }
        }
        $getProduct = $db->fetchAll('SELECT vnb_restaurant_product.name, vnb_restaurant_product.price, vnb_restaurant_product.id FROM vnb_restaurant_product, vnb_order_product WHERE vnb_order_product.id_order = '.$data['0']['id'].' AND vnb_restaurant_product.id = vnb_order_product.id_product');
        $i=0;
        foreach($getProduct as $key=>$value){
            $data['product'][$i]['name'] = self::suppr_accents($value['name']);
            $data['product'][$i]['price'] = $value['price'];
            if($id){
                $data['product'][$i]['id'] = intval($value['id']);
            }
            $i++;
        }
        return $data;
    }

    /*
     * Delete all special chars
     *
     * @param string $str
     * @param string $encoding
     */
    private function suppr_accents($str, $encoding='utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        return $str;
    }


    public static function updateStock(){
        $getDetail = self::getOrderDetail(true);
        foreach($getDetail['menu'] as $key=>$value){
            foreach($value['product'] as $pKey=>$pValue){
                $idArray[] = $pValue['id'];
            }
        }
        foreach($getDetail['product'] as $key=>$value){
            $idArray[] = intval($value['id']);
        }
        foreach($idArray as $key=>$value){
            $db = new DatabaseController();
            $request = $db->fetchAll('SELECT vnb_restaurant_product_composition.quantity, vnb_restaurant_stock.stock_value, vnb_restaurant_stock.id  
                                          FROM vnb_restaurant_product_composition, vnb_restaurant_stock WHERE vnb_restaurant_product_composition.id_product = '.intval($value).'
                                           AND vnb_restaurant_stock.id_restaurant = '.$_SESSION['id_restaurant'].' AND vnb_restaurant_product_composition.id_component = vnb_restaurant_stock.id_component');
            $getDiff = intval($request['0']['stock_value']) - intval($request['0']['quantity']);
            if($getDiff<0){
                $getDiff = 0;
            }
            $update = $db->update('UPDATE vnb_restaurant_stock SET stock_value = '.$getDiff.' WHERE id = '.$request['0']['id']);
        }
    }

    public static function getAllOrders(){
        $db = new DatabaseController();
        $getAll = $db->fetchAll('SELECT vnb_order.id, vnb_order.date_inserted, vnb_order.total, vnb_users.name, vnb_users.firstname FROM vnb_order, vnb_users WHERE vnb_order.id_restaurant = :id_restaurant AND vnb_order.id_user = vnb_users.id', [ 'id_restaurant' => $_SESSION['id_restaurant']]);
        sort($getAll);
        foreach($getAll as $key=>$value){
            $getAll[$key]['date_inserted'] = date( "d/m/Y - H:i:s", strtotime($value['date_inserted']));

        }
        return $getAll;
    }
}