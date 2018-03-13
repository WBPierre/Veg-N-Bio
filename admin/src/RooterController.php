<?php
echo 'ok class';
class RooterController{
	echo 'in';

	public static function getPage(){
		echo "ok";
		$URI = $_SERVER['REQUEST_URI'];
		$URI = str_replace("/admin","",$URI);
		if($URI == '/'){
			$link = 'src/FormValidator.php';
			$string = LanguageController::translate('index');
			echo $twig->render('test.twig', [ 'trans' => $string, 'link'=>$link ] );
		}
	}
}