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

    public function getProducerDetails($id){
        $db = new DatabaseController();
        $request = "SELECT firstname FROM vnb_users WHERE id = :id";
        $user = $db->fetch($request,['id' => $id]);

        return $user;
    }

    public function getAllProducts($id){

        $products = [];

        $db = new DatabaseController();
        $request = "SELECT id_products FROM vnb_announce_products WHERE id_announce = :id";
        $id_products = $db->fetchAll($request,['id' => $id]);

        foreach ($id_products as $id_product){

            $request = "SELECT * FROM vnb_offers WHERE id = :id_product";
            $products = $db->fetch($request,['id' => $id_product]);
        }

        return $products;
    }
}