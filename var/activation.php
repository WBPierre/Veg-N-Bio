<?php
require_once "../config/config.php";
if(!isset($_GET['key']) || empty($_GET['key'])){
    die("0");
}else{
    $db = new DatabaseController();
    $request = $db->fetchAll('SELECT * FROM vnb_users WHERE activation_key = :key',[ 'key' => $_GET['key'] ]);
    if($request[0]['active'] == 1){
        header('Location: /');
    }
    $string = LanguageController::translate('index');
    echo $twig->render('login/login.twig', [ 'trans' => $string, 'lang' => 'fr' ] );
}