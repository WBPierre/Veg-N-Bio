<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-13 10:51:13
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-13 10:55:30
 */
	/*
	*	Class DatabaseController
	* 	Permet de controller et d'instancier la connexion BDD. Prépare l'ensemble des requêtes.
	*/
echo 'on y est';
class DatabaseController{	

	private $db;

	function __construct(){
		try{
			$this->db = new PDO( 
				"mysql:host=".DB_HOST.";dbname=".DB_NAME, 
				DB_USER  , 
				DB_PWD );
		}catch(Exception $e){
			die("Erreur SQL : ".$e->getMessage());
		}
		die('OK BDD');
	}