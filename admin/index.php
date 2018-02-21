<?php

require_once "config/config.php";
$string = LanguageController::translate('index');
echo $twig->render('home.twig', [ 'trans' => $string ] );
