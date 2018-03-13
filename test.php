<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-08 16:46:23
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-08 17:02:05
 */
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$username = $obj['username'];
$password = $obj['password'];
$data = 'Ton id : '.$username.' et mdp :'.$password;

echo json_encode($data);