

<?php

$db = new PDO('mysql:host=localhost;dbname=VegNBio', 'tristan', 'project');


$request = $db->prepare("SELECT * FROM vnb_restaurant");
$request->execute();
$result = $request->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
