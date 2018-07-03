<?php

	/*
	*	Class LanguageController
	* 	Handle the language selection for the user
	*/
class LanguageController{	
	/*
	* Get the traductions from a specific file
	* 
	* @param $lang 
	* @return PHP object
	*/
	private function getFile($lang){
		switch($lang){
			case 'fr':
				$trans = file_get_contents(ROOT.'/translations/'.$lang.'/'.$lang.'_translations.json');
				break;
			default:
				$trans = file_get_contents(ROOT.'/translations/en/en_translations.json');
		}
		return json_decode($trans);
	}

	/*
	* Send all the traductions for the page
	* @param $page
	* @return PHP Object
	 */
	public static function translate($page){
		$data = self::getFile($_SESSION['lang']);
		$admin = 'admin';
		return $data->$admin->$page;
	}
}
