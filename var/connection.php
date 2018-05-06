<?php

require_once "../config/config.php";
if($_POST['log'] == "login"){
    if(isset($_POST['email'], $_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['pwd'])){

        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['pwd']
        ];
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $db = new DatabaseController();
            $response = $db->fetchAll('SELECT * FROM vnb_users WHERE email = :email', [ 'email' => $data['email'] ]);
            if(count($response) == 1){
                if(password_verify($data['password'], $response[0]['password'])){
                    if($response[0]['active'] == 0){
                        die(1);
                    }
                    $_SESSION['logUser'] = true;
                    $_SESSION['id'] = $response[0]['id'];
                    $name = strtoupper(substr($response[0]['firstname'],0,1));
                    $name .= '.'.$response[0]['name'];
                    die($name);
                }else{
                    $headers = "From: d.pierrebox@gmail.com\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $mail = file_get_contents("../emails/header.html");
                    $mail.= "TEST 123";
                    $mail .= file_get_contents("../emails/footer.html");
                    mail('d.pierrebox@gmail.com', 'test', $mail,$headers);
                    die("0");
                }
            }else{
                die("0");
            }
        }
    }else{
        die("0");
    }
}
if($_POST['log'] == 'signin'){
    if(isset($_POST['email'], $_POST['pwd'], $_POST['confirm']) && !empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['confirm'])){
        if($_POST['pwd'] !== $_POST['confirm']){
            die('0');
        }
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'active' => 0,
            'access_level' => 0
        ];
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $db = new DatabaseController();
            $response = $db->insert('INSERT INTO vnb_users(email,password, active, access_level) VALUES (:email, :password, :active, :access_level)', $data);
            die("1");
        }
    }
    die("0");
}
die("0");
