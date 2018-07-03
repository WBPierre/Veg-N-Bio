<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
$request = new DatabaseController();

$url = LinkController::requestUrl($_GET['url']);

$explodeUrl = substr($_GET['url'], -2);


if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){
    $db = new DatabaseController();
    $request = $db->fetchAll('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => $_SESSION['id']]);
    $name = $request[0]['firstname']." ".$request[0]['name'];
    switch($_GET['url']){
        case 'visit':
            header('Location: ThreeJS/index.html');
            break;
        case 'order':
            echo $twig->render('order/order.twig', ['trans' => $string]);
            break;
        case 'showMenu':
            $request = new ProductController();
            $array = $request->getAllProducts();
            echo $twig->render('showMenu/showMenu.twig', ['products' => $array, 'trans' => $string]);
            break;
        case 'marketPlace':
            $request = new AnnounceController();
            $offers = $request->getAllOffers();
            $ads = $request->getAds();
            echo $twig->render('marketPlace/marketPlace.twig', ['ads' => $ads, 'offers' => $offers, 'trans' => $string]);
            break;
        case 'addAnnounce':
            $request = new AnnounceController();
            $offers = $request->getAllOffers();
            echo $twig->render('addAnnounce/addAnnounce.twig', ['offers' => $offers, 'trans' => $string]);
            break;
        case 'seeAnnounce?id='.$explodeUrl:
            $request = new AnnounceController();
            $details = $request->getDetailsAnnounce($explodeUrl);
            $producer = $request->getProducerDetails($explodeUrl);
            $products = $request->getAllProducts($explodeUrl);
            echo $twig->render('seeAnnounce/seeAnnounce.twig', ['products' => $products, 'producer' => $producer ,'details' => $details, 'trans' => $string]);
            break;
        default:
            echo $twig->render('home/home.twig', [ 'trans' => $string, 'name'=>$name, 'intro' => true ] );
            break;
    }
}else {

    switch($url['url']) {
        case 'visit':
            header('Location: ThreeJS/index.html');
            break;
        case 'order':
            echo $twig->render('order/order.twig', ['trans' => $string]);
            break;
        case 'showMenu':
            $request = new ProductController();
            $array = $request->getAllProducts();
            echo $twig->render('showMenu/showMenu.twig', ['products' => $array,'trans' => $string]);
            break;
        case 'marketPlace':
            $request = new AnnounceController();
            $offers = $request->getAllOffers();
            echo $twig->render('marketPlace/marketPlace.twig', ['offers' => $offers, 'trans' => $string]);
            break;
        case 'addAnnounce':
            echo $twig->render('addAnnounce/addAnnounce.twig', ['trans' => $string]);
            break;
        case 'seeAnnounce?id='.$idUrl:
            $request = new AnnounceController();
            echo $twig->render('seeAnnounce/seeAnnounce.twig', ['id' => 14, 'trans' => $string]);
            break;
        default:
            echo $twig->render('home/home.twig', ['trans' => $string, 'intro' => true]);
            break;
    }
}
