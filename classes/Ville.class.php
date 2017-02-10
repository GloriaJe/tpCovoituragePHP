<?php
class Ville{

	private $vil_num;
	private $vil_nom;

	public function __construct($valeurs = array()){

		if(!empty($valeurs)){
			$this ->affecte($valeurs);
		}
	}

	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur){
			switch($attribut){
				case 'vil_num' : $this->setVil_num($valeur);
				break;

				case 'vil_nom' : $this->setVil_nom($valeur);
				break;
			}
		}
	}

	public function setVil_num($num){
		//controle des valeurs
		/*if (!is_int($num)){
			trigger_error('Le numéro de la ville doit être un nombre entier !', E_USER_WARNING);
			return;
		}*/
		$this ->vil_num = $num;
	}

	public function getVil_num(){

		return $this->vil_num;
	}

	public function setVil_nom($nom){
		//controle des valeurs
		/*if (!is_string($nom)){
			trigger_error('Le nom de la ville doit être une chaine de caractères !', E_USER_WARNING);
			return;
		}*/
		$this ->vil_nom = $nom;
	}

	public function getVil_nom(){

		return $this->vil_nom;
	}
}
