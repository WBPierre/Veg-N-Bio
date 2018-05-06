<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
if(isset($_SESSION['logUser']) && !empty($_SESSION['logUser'])){
    echo "ok";
}else{
    echo $twig->render('home/home.twig', [ 'trans' => $string ] );
}
