<?php
require_once "../config/config.php";
/**
 * @Author: Pierre
 * @Date:   2018-03-23 14:11:39
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-17 14:06:40
 */
$_SESSION['adminLog'] = true;
$_SESSION['access_level'] = 3;
$_SESSION['id'] = 44;
$_SESSION['id_restaurant'] = 1;
header('Location: /admin/');