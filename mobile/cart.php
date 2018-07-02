

<?php

$db = new PDO('mysql:host=localhost;dbname=VegNBio', 'tristan', 'project');


$json = file_get_contents('php://input');

$obj = json_decode($json,true);


echo json_encode('test');
