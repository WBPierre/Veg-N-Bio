<?php

require_once "config/config.php";

$url = LinkController::requestUrl($_GET['url']);

if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true && $_SESSION['access_level'] >= 1){
	$check['id'] = $_SESSION['id'];
	$string = LanguageController::translate('dashboard');
	$request = new DatabaseController();
	$today = date("Y-m-d");
	if(($getData = $request->fetchAll("SELECT vnb_contract_check.date_inserted FROM vnb_contract, vnb_contract_check WHERE vnb_contract.id_employee = :id AND vnb_contract_check.id_contract = vnb_contract.id AND vnb_contract_check.date_inserted LIKE '".$today."%'", $check)) == NULL){
		$error = true;
		$badge = false;
		$time = "";
	}else{
		$badge = true;
		$max = max(array_keys($getData));
		$time = substr($getData[$max]['date_inserted'],11,16);
	}
	switch($url['url']){
		case 'employeesManagement':
			$data = new EmployeeManagerController();
			$array = $data->getAllEmployees();
			echo $twig->render('employeesManagement/employeesManagement.twig', [ 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'employees' => $array, 'alert' => $url ] );
			break;
        case 'discountManagement':
            $response = $request->fetchAll('SELECT * FROM vnb_discount');
            echo $twig->render('discountManagement/discountManagement.twig', [ 'discounts' => $response, 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url ] );
            break;
		case 'addEmployee':
			if($_SESSION['access_level'] >= 2){
				echo $twig->render('employeesManagement/addEmployee.twig', [ 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url ] );
				break;
			}
		case 'manageProducts':
			if($_SESSION['access_level'] >= 2){
				$request = new ProductController();
				$array = $request->getAllProducts();
				$menus = $request->getMenuOnProduct();
				echo $twig->render('manageProducts/manageProducts.twig', [ 'menus' => $menus,'products' => $array,'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'img' => PRODUCT_IMAGE_FOLDER,'trans' => $string, 'alert' => $url ] );
				break;
			}
		case 'addProduct':
			if($_SESSION['access_level'] >= 2){
				$request = new ProductController();
				$array = $request->getAllMenus(true);
				$component = $request->getComposant();
				echo $twig->render('manageProducts/addProduct.twig', [ 'component' => $component, 'array' => $array, 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url ] );
				break;
			}
		case 'manageMenus':
			if($_SESSION['access_level'] >= 2){
				$menu = new ProductController();
				$array = $menu->getAllMenus(false);
				echo $twig->render('manageMenus/manageMenus.twig', [ 'menus' => $array, 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url] );
			}
			break;
		case 'cashDesk':
			$request = new ProductController();
			$array = $request->getAllProducts();
			$menu = $request->getAllMenus(true);
			echo $twig->render('cashDesk/cashDesk.twig', [ 'menus' => $menu, 'products' => $array, 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url] );
			break;
		case 'inventoryManagement':
		    $data = ProductController::getStock();
		    $control = new InventoryManagementController();
		    $request = $control->getAllOffers();
			if($_SESSION['access_level'] >= 2 ){
				echo $twig->render('inventoryManagement/inventoryManagement.twig', [ 'stock' => $data, 'array' => $request ,'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url] );
			}
			break;
        case 'kitchenInterface':
            $request = new ProductController();
            $array = $request->getAllProducts();
            $menu = $request->getAllMenus(true);
            echo $twig->render('kitchenInterface/kitchenInterface.twig', [ 'menus' => $menu, 'products' => $array, 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'alert' => $url] );
            break;
		default:
		    $data = DashboardController::getAllData();
		    echo $twig->render('dashboard/dashboard.twig', [ 'data' => $data, 'badge' => $badge, 'time' => $time,'id' => $_SESSION['id'], 'access_level' => $_SESSION['access_level'],'lang' => $_SESSION['lang'],  'trans' => $string, 'alert' => $url ] );
	}
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string, 'alert' => $url ] );
}

