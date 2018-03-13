<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-09 10:00:43
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-09 11:34:51
 */
require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: '.$_SERVER['HTTP_REFERER']);
}
$validator = new FormValidatorController($_POST);
$check = $validator->isValid();
if($check){
	$_SESSION['adminLog'] = true;
}
header('Location: '.$_SERVER['HTTP_REFERER']);
