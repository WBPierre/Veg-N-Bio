

<?php

$db = new PDO('mysql:host=localhost;dbname=VegNBio', 'tristan', 'project');


$json = file_get_contents('php://input');

$obj = json_decode($json,true);

$email = strtolower($obj['email']);
$password = $obj['password'];


$request = $db->prepare("SELECT * FROM vnb_users");
$request->execute();
$result = $request->fetchAll(PDO::FETCH_ASSOC);


foreach ($result as $value) {
    if(strcmp(strtolower($value['email']), $email) == 0){
        if(password_verify($password, $value['password'])) {
            echo json_encode($value);
            break;
        }
    }
}

echo "test";