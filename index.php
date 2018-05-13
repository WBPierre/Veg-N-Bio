<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
$request = new DatabaseController();

$url = LinkController::requestUrl($_GET['url']);


if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){
    echo "ok";
}else{

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
        default:
            echo $twig->render('home/home.twig', ['trans' => $string]);
            break;
    }
}
