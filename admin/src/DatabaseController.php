<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-13 10:51:13
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-23 12:19:13
 */
	/*
	*	Class DatabaseController
	* 	Allow to controle the DB connexion and requests.
	*/
class DatabaseController{	

	private $db;
	private $response;

	/*
	* Construct the DB connexion
	* 
	 */
	function __construct(){
		try{
			$this->db = new PDO( 
				"mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8", 
				DB_USER  , 
				DB_PWD);
		}catch(Exception $e){
			die("Erreur SQL : ".$e->getMessage());
		}
	}

	/*
	* Handle the database Request
	* @param $request
	* @param $data
	* @return Boolean
	 */

	private function requestDB($request, $data){
		$this->response = $this->db->prepare($request);
		// if($data != NULL){
		// 	if(!is_array($data)){
		// 		die('Error in the SQL request - Array is necessary as an argument !');
		// 	}
		// 	$this->response->execute($data);
		// }else{
			$this->response->execute([]);
		// }
		if($this->response){
			return true;
		}else{
			return false;
		}
	}

	/*
		Handle a fetchAll on a request
		@param $request
		@param $data
		@return PHP Array
	 */

	public function fetchAll($request, $data = NULL){
		if($request == NULL){
			return 0;
		}
		$valid = $this->requestDB($request, $data);
		if(!$valid){
			die('Error in the SQL request - The request was invalid !');
		}
		return $this->response->fetchAll();
	}
	/*
		Handle a update on a request
		@param $request
		@param $data
		@return Boolean
	 */

	public function update($request, $data = NULL){
		if($request == NULL){
			return 0;
		}
		$valid = $this->requestDB($request,$data);
		if(!$valid){
			die('Error in the SQL request - The request was invalid !');
		}else{
			return true;
		}
	}

	/*
		Handle a fetch on a request
		@param $request
		@return PHP Array
	 */
	public function fetch($request, $data = NULL){
		if($request == NULL){
			return 0;
		}
		$valid = $this->requestDB($request, $data);
		if(!$valid){
			die('Error in the SQL request - The request was invalid !');
		}
		return $this->response->fetch();
	}

	/*
		Handle a count on a request
		@param $request
		@return $number
	 */
	public function rowCount($request, $data = NULL){
		if($request == NULL){
			return 0;
		}
		$valid = $this->requestDB($request, $data);
		if(!$valid){
			die('Error in the SQL request - The request was invalid !');
		}
		$number = $this->response->rowCount();
		return $number;
	}

	/*
		Handle an insert into the database
		@param request
		@return Boolean
	 */
	public function insert($request, $data = NULL){
		if($request == NULL){
			return 0;
		}
		$valid = $this->requestDB($request, $data);
		if(!$valid){
			die('Error in the SQL request - The request was invalid !');
		}
		return $valid;
	}
		
}