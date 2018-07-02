<?php
echo __DIR__."<br>";
$cmd = "/var/www/dev/admin/admin/var/C/xmlParser/execute 44 1 2>&1";
$out = shell_exec($cmd);
echo "<br> C located in :".__DIR__."/C/xmlParser/execute";
echo "<br>Command executed = '".$cmd."'";
echo "<br>Result : ".$out;
echo "<br>done";