<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
$url = LinkController::requestUrl($_GET['url']);
$db = new DatabaseController();
$response = $db->fetchAll('SELECT * FROM vnb_restaurant');
foreach($response as $key=>$value){
    $restaurant[$value['id']]=$value['name'];
}

if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){

    $request = $db->fetchAll('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => $_SESSION['id']]);
    $name = $request[0]['firstname']." ".$request[0]['name'];

    switch($_GET['url']){
        case 'visit':
            header('Location: ThreeJS/index.html');
            break;
        case 'profil':
            echo $twig->render('users/users.twig', [ 'trans' => $string,'lang' => $_SESSION['lang'] ]);
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
            echo $twig->render('showMenu/showMenu.twig', ['products' => $array, 'trans' => $string, 'name' => $name, 'lang' => $_SESSION['lang'] ]);
            break;
        default:
            echo $twig->render('home/home.twig', [ 'trans' => $string, 'name'=>$name, 'intro' => true, 'restaurant' => $restaurant, 'lang' => $_SESSION['lang'] ] );
            break;
    }
}else{

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
        default:
            echo $twig->render('home/home.twig', ['trans' => $string, 'intro' => true, 'restaurant' => $restaurant, 'lang' => $_SESSION['lang'] ]);
            break;
    }
}
