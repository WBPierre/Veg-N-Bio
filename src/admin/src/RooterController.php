<?php
require_once "config/config.php";
class RooterController{

	private $url;

	function __construct(){
		$this->url = $_GET['url'];
	}

	public function getRoute(){
		switch($this->url){
			case 'employeesManagement':

				$db = new DatabaseController();
				$data = $db->fetchAll('SELECT * FROM vnb_users WHERE employee = 1');
				$contracts = $db->fetchAll('SELECT * FROM vnb_contract');

				$string = LanguageController::translate('dashboard');
				echo $twig->render('employeesManagement/employeesManagement.twig', [ 'trans' => $string, 'employees' => $data, 'contract' => $contracts[0] ] );
				break;
			default:
				$string = LanguageController::translate('dashboard');
				echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
		}

	}
}