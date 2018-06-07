<?php

class EmailController{
    function __construct(){

    }
    public static function sendThanksProducer($email){
        if($_SESSION['lang'] == 'fr'){
            $subject = "Livraison effectuée";
            $message = "Bonjour,<br>Nous tenions à vous remercier pour cette livraison. Nous n'hésiterons pas à revenir vers vous si jamais nous souhaitons de nouveau faire affaire avec vous.<br>";
        }else{
            $subject = "Delivery done";
            $message = "Hello, <br> We wanted to thank you for this delivery. We will not hesitate to come back to you if we ever wish to do business with you again.<br>";
        }
        $headers = "From: reply.projet2018@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $bodyFile = file_get_contents(ROOT."/emails/header.html");
        $bodyFile .= $message;
        $bodyFile .= file_get_contents(ROOT."/emails/footer.html");
        mail($email,$subject,$bodyFile,$headers);
    }

    public static function sendOrderConfirmation($email){
        $db = new DatabaseController();
        $info = $db->fetchAll('SELECT * FROM vnb_restaurant WHERE id = :id',[ 'id' => $_SESSION['id_restaurant']]);

        if($_SESSION['lang'] == 'fr'){
            $subject = "Commande effectuée";
            $message = "Bonjour,<br>Suites aux multiples recommandations pour vos produits, nous aimerions vous commander votre offre. Nous règlerons en liquide à l'arrivée. Voici nos informations de livraisons :<br>";
            $message .= "Restaurant : ".$info['0']['name']."<br>".$info['0']['address']."<br>".$info['0']['zip_code']." ".$info['0']['city']."<br><br>Téléphone :".$info['0']['phone'];
        }else{
            $subject = "Delivery done";
            $message = "Hello, <br> Suites with multiple recommendations for your products, we would like to order your offer. We will settle in cash on arrival. Here is our information :<br>";
            $message .= "Restaurant : ".$info['0']['name']."<br>".$info['0']['address']."<br>".$info['0']['zip_code']." ".$info['0']['city']."<br><br>Phone :".$info['0']['phone'];
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