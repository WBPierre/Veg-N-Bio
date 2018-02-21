<?php

	/*
	*	Class LanguageController
	* 	Permet de définir la langue utilisé par l'utilisateur, de charger la traduction correspondante, et de la modifier
	*/
class LanguageController{	
	/*
	* Récupère les traductions selon la langue
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
	* GETTER Envoie les traductions pour la page demandée
	* @param $page
	* @return PHP Object
	 */
	/*
	* Commentaire à DELETE : 
	* public signifie qu'on peut atteindre cette fonction depuis n'importe quelle instance de la classe, directement. Notion de Getter/setter. Dans une classe il y a majoritairement ces 2 types. Getter pour GET, pour obtenir une infos. Setter pour du coup "mettre en place une info", la conserver. L'intérêt de mettre en private est d'éviter tous les affichages des fichiers, ou chemin etc. + boost de sécurité et de propreté comme fonction = 30 lignes max. Ici ce n'est pas une obligation de tout séparer, mais si on met en backoffice un changement de texte ou autre, cela peut être intéressant d'avoir cette fonction déjà faite. Toujours penser à la réutilisation ! On aura beaucoup de classes outils. Du genre celle qui récupère les données bdd, celle qui va faire les vérifs d'un formulaire, qui va mettre en place un formulaire, celle pour la connexion user, tout est imbriqué.  
	* private signie qu'on ne peut atteindre cette fonction que depuis une instance de la classe.
	* static signife qu'on peut appeler simplement cette fonction sans déclarer d'instance de la classe. Pour faire simple, une instance = tableau/structure avec des fonctions et des propriétés.
	* self fait référence à la classe dans laquelle on est. 
	 */
	public static function translate($page){
		$data = self::getFile($_SESSION['lang']);
		$admin = 'admin';
		return $data->$admin->$page;
	}
}
