<?php

class AnnounceController{


    /*
        Nothing for now
     */

    function __construct(){

    }


    public function getAllOffers(){
        $db = new DatabaseController();
        $request = "SELECT * FROM vnb_offers WHERE id_producer = :id AND state = 0";
        $offers = $db->fetchAll($request,['id' => $_SESSION['id']]);

        return $offers;
    }

    public function getAds(){
        $db = new DatabaseController();
        $request = "SELECT * FROM vnb_announce WHERE id_producer = :id";
        $ads = $db->fetchAll($request,['id' => $_SESSION['id']]);

        return $ads;
    }

    public function getDetailsAnnounce($id){
        $db = new DatabaseController();
        $request = "SELECT * FROM vnb_announce WHERE id = :id";
        $details = $db->fetch($request,['id' => $id]);

        return $details;
    }

    public function getProducerDetails($id_announce){
        $db = new DatabaseController();
        $request = "SELECT id_producer FROM vnb_announce WHERE id = :id_announce";
        $id_producer = $db->fetch($request,['id_announce' => $id_announce]);

        $request = "SELECT * FROM vnb_users WHERE id = :id_producer";
        $producer = $db->fetch($request,['id_producer' => $id_producer[0]]);

        return $producer;
    }

    public function getAllProducts($id_announce)
    {

        $products = [];

        $db = new DatabaseController();
        $request = "SELECT id_products FROM vnb_announce_products WHERE id_announce = :id_announce";
        $id_products = $db->fetchAll($request, ['id_announce' => $id_announce]);


        foreach ($id_products as $id_product) {

            $request = "SELECT * FROM vnb_offers WHERE id = :id_product";
            array_push($products,$db->fetch($request, ['id_product' => $id_product[0]]));

        }

        return $products;

    }

}