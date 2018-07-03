
<?php

$db = new PDO('mysql:host=localhost;dbname=VegNBio', 'tristan', 'project');


$json = file_get_contents('php://input');

$obj = json_decode($json,true);


$request = $db->prepare('SELECT * FROM vnb_order  WHERE id_user = '. $obj['id']);
$request->execute();
$result = $request->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);