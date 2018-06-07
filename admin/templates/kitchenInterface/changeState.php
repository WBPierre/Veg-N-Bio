<?php


require_once "../../config/config.php";

$db = new DatabaseController();
$id = intval($_POST['id']);

$statement = $db->update("UPDATE vnb_order SET state = 1 WHERE id = ". $id);

echo $id;