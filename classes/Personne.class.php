<?php
class Personne{

	private $per_num;
	private $per_nom;
	private $per_prenom;
	private $per_tel;
	private $per_mail;
	private $per_login;
	private $per_pwd;

	public function __construct($valeurs = array()){

		if(!empty($valeurs)){
			$this ->affecte($valeurs);
		}
	}

	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur){
			switch($attribut){
				case 'per_num' : $this->setPer_num($valeur);
				break;

				case 'per_nom' : $this->setPer_nom($valeur);
				break;

				case 'per_prenom' : $this->setPer_prenom($valeur);
				break;

				case 'per_tel' : $this->setPer_tel($valeur);
				break;

				case 'per_mail' : $this->setPer_mail($valeur);
				break;

				case 'per_login' : $this->setPer_login($valeur);
				break;

				case 'per_pwd' : $this->setPer_pwd($valeur);
				break;
			}
		}
	}

	public function getPer_num(){
		return $this->per_num;
	}

	public function setPer_num($per_num){
		//controle des valeurs
		$this->per_num = $per_num;
	}

	public function getPer_nom(){
		return $this->per_nom;
	}

	public function setPer_nom($per_nom){
		//controle des valeurs
		$this->per_nom = $per_nom;
	}

	public function getPer_prenom(){
		return $this->per_prenom;
	}

	public function setPer_prenom($per_prenom){
		//controle des valeurs
		$this->per_prenom = $per_prenom;
	}

	public function getPer_tel(){
		return $this->per_tel;
	}

	public function setPer_tel($per_tel){
		//controle des valeurs
		$this->per_tel = $per_tel;
	}

	public function getPer_mail(){
		return $this->per_mail;
	}

	public function setPer_mail($per_mail){
		//controle des valeurs
		$this->per_mail = $per_mail;
	}

	public function getPer_login(){
		return $this->per_login;
	}

	public function setPer_login($per_login){
		//controle des valeurs
		$this->per_login = $per_login;
	}

	public function getPer_pwd(){
		return $this->per_pwd;
	}

	public function setPer_pwd($per_pwd){
		//controle des valeurs
		$this->per_pwd = $per_pwd;
	}
}
