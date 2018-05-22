<?php

class EmailController{
    function __construct(){

    }


    public static function sendActivation($email, $activation_key){
        if($_SESSION['lang'] == 'fr'){
            $subject = "Activation de votre compte";
            $message = "Bienvenue,<br> Merci de procéder à l'activation de votre compte en cliquant sur le lien suivant :<br><a href='https://admin.pierredelmer.com/var/activation.php?key=".$activation_key."'><button>Activer</button></a><br>";
        }else{
            $subject = "Account activation";
            $message = "Welcome,<br> Please activate your account by clicking on the following link : <a href='https://admin.pierredelmer.com/var/activation.php?key=".$activation_key."'><button>Activate</button></a><br>";
        }
        $headers = "From: reply.projet2018@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $bodyFile = file_get_contents(ROOT."/emails/header.html");
        $bodyFile .= $message;
        $bodyFile .= file_get_contents(ROOT."/emails/footer.html");
        mail($email,$subject,$bodyFile,$headers);
    }
}