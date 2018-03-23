<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-23 14:11:39
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-23 16:06:58
 */
$output = shell_exec('C/test2');
echo $output;
var_dump($_COOKIE['PHPSESSID']);