<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){
    $db = new DatabaseController();
    $request = $db->fetchAll('SELECT * FROM vnb_users WHERE id = :id',[ 'id' => $_SESSION['id']]);
    $name = $request[0]['firstname']." ".$request[0]['name'];
    switch($_GET['url']){
        case 'order':
            echo $twig->render('order/order.twig', [ 'trans' => $string, 'name'=>$name ] );
            break;
        default:
            echo $twig->render('home/home.twig', [ 'trans' => $string, 'name'=>$name, 'intro' => true ] );
            break;
    }
}else{
    echo $twig->render('home/home.twig', [ 'trans' => $string ] );
}
