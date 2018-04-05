<?php
require_once "../config/config.php";
/**
 * @Author: Pierre
 * @Date:   2018-03-23 14:11:39
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-03 12:50:24
 */
$_SESSION['adminLog'] = true;
$_SESSION['access_level'] = 3;
$_SESSION['id'] = 44;
header('Location: /admin/');