<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
$url = LinkController::requestUrl($_GET['url']);
$explodeUrl = substr($_GET['url'], -2);
$db = new DatabaseController();
$response = $db->fetchAll('SELECT * FROM vnb_restaurant');
foreach($response as $key=>$value){
    $restaurant[$value['id']]=$value['name'];
}

if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){

    $request = $db->fetchAll('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => $_SESSION['id']]);
    $name = $request[0]['firstname']." ".$request[0]['name'];

    switch($url['url']){
        case 'visit':
            header('Location: ThreeJS/index.html');
            break;
        case 'profile':
            $data = UserController::getUserData();
            echo $twig->render('userProfile/userProfile.twig', [ 'user' => $data, 'trans' => $string,'name' => $name, 'lang' => $_SESSION['lang'], 'alert' => $url ]);
            break;
        case 'order':
            $request = new ProductController();
            $array = $request->getAllProducts();
            $menu = $request->getAllMenus(true);
            echo $twig->render('order/order.twig', [ 'trans' => $string, 'menus' => $menu, 'products' => $array, 'lang' => $_SESSION['lang'] ]);
            break;
        case 'showMenu':
            $request = new ProductController();
            $array = $request->getAllProducts();

            echo $twig->render('showMenu/showMenu.twig', ['products' => $array, 'trans' => $string, 'name' => $name, 'lang' => $_SESSION['lang']]);
            break;
        case 'marketPlace':
            $request = new AnnounceController();
            $offers = $request->getAllOffers();
            $ads = $request->getAds();
            echo $twig->render('marketPlace/marketPlace.twig', ['ads' => $ads, 'offers' => $offers,'name' => $name, 'trans' => $string]);
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
            echo $twig->render('home/home.twig', [ 'trans' => $string, 'name'=>$name, 'intro' => true, 'restaurant' => $restaurant, 'lang' => $_SESSION['lang'] ] );
            break;
    }
}else {

    switch($url['url']) {
        case 'visit':
            header('Location: ThreeJS/index.html');
            break;
        case 'order':
            echo $twig->render('order/order.twig', ['trans' => $string, 'lang' => $_SESSION['lang']]);
            break;
        case 'showMenu':
            $request = new ProductController();
            $array = $request->getAllProducts();
            echo $twig->render('showMenu/showMenu.twig', ['products' => $array,'trans' => $string, 'lang' => $_SESSION['lang']]);
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
        case 'forgotPassword':
            echo $twig->render('password/password.twig', ['trans' => $string, 'lang' => $_SESSION['lang']]);
        default:
            echo $twig->render('home/home.twig', ['trans' => $string, 'intro' => true, 'restaurant' => $restaurant, 'lang' => $_SESSION['lang'] ]);
            break;
    }
}
