<?php

/**
 * @Author: Pierre
 * @Date:   2018-04-11 09:18:22
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-12 12:18:38
 */

/*
	Class LinkController
	This class handles all the redirect link and parse the url
 */
class LinkController{


	/*
		Nothing for now
	 */
	function __construct(){

	}

	/*
		Handle all links and redirect with error or success
		@param $error
		@param $root
	 */
	public static function redirect($error, $root = NULL){
		$url = $_SERVER['HTTP_REFERER'];
		if($error){
			if(preg_match('/success/',$url)){
				$url = preg_replace('/\?success/', "", $url);
			}
			if(preg_match('/error/',$url)){
				header('Location: '.$url);
			}else{
				header('Location: '.$url.'?error');
			}
		}else{
			if(preg_match('/error/',$url)){
				$url = preg_replace('/\?error/', "", $url);
			}
			if(preg_match('/success/',$url)){
				header('Location: '.$url);
			}else{
				header('Location: '.$url.'?success');
			}
		}
	}

	/*
		This class handles the parsing of the URL for the rooter
		@param $request
		@return PHP Array
	 */

	public static function requestUrl($request){
		$error = false;
		$success = false;
		if($request == NULL && preg_match('/error/',$_SERVER['REQUEST_URI'])){
			$url = '?error';
		}else{
			$url = $request;
		} 
		if(preg_match('/error/',$url)){
			$error = true;
			$url = preg_replace('/\?error/', "", $url);
		}

		if(preg_match('/success/', $url)){
			$success = true;
			$url = preg_replace('/\?success/', "", $url);
		}
		$array['url'] = $url;
		$array['error'] = $error;
		$array['success'] = $success;
		return $array;
	}
}