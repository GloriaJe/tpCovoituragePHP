<?php
class PersonneManager{

	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listePersonne = array();

		$sql = 'SELECT per_num, per_nom, per_prenom FROM personne';
		$req = $this->db->query($sql);
		while($personne = $req->fetch(PDO::FETCH_OBJ)){
			$listePersonne[] = new Personne($personne);
		}
		return $listePersonne;
		$req->closeCursor();
	}
	/*
	* Fonction permettant d'ajouter une personne dans la base de données
	* Paramètres :
	*		$personne : la personne à ajouter
	*/
	public function add($personne){
		$req = $this->db->prepare('INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd)');
		$req->bindValue(':per_nom', $personne->getPer_nom());
		$req->bindValue(':per_prenom', $personne->getPer_prenom());
		$req->bindValue(':per_tel', $personne->getPer_tel());
		$req->bindValue(':per_mail', $personne->getPer_mail());
		$req->bindValue(':per_login', $personne->getPer_login());
		$req->bindValue(':per_pwd', $personne->getPer_pwd());
		$req->execute();
	}

	/*
	* Fonction qui retourne le nombre de personnes
	*/
	public function getNb(){
		$sql = 'SELECT COUNT(*) AS total FROM personne';
		$req = $this->db->query($sql);
		$nb = $req->fetch(PDO::FETCH_OBJ);
		return $nb->total;
	}

	/*
	* Fonction qui retourne la dernière personne ajoutée
	*/
	public function getLastPers(){
		$sql = 'SELECT * FROM personne ORDER BY per_num DESC LIMIT 1';
		$req = $this->db->query($sql);
		$pers = $req->fetch(PDO::FETCH_OBJ);
		$personne = new Personne($pers);
		return $personne;
	}

	/*
	* Fonction permettant de récupérer une personne par son numéro
	* Paramètres :
	*		$num : le numéro de la personne à récupérer
	*/
	public function getPersById($id){
		$sql = 'SELECT * FROM personne WHERE per_num ="'.$id.'"';
		$req = $this->db->query($sql);
		$pers = $req->fetch(PDO::FETCH_OBJ);
		$personne = new Personne($pers);
		return $personne;
	}

	/*
	* Fonction permettant de récupérer une personne par son login
	* Paramètres :
	*		$num : le numéro de la personne à récupérer
	*/
	public function getPersByLogin($login){
		$sql = 'SELECT * FROM personne WHERE per_login ="'.$login.'"';
		$req = $this->db->query($sql);
		$pers = $req->fetch(PDO::FETCH_OBJ);
		$personne = new Personne($pers);
		return $personne;
	}

	/*
	* Fonction qui permet de savoir si une personne est un étudiant
	* Paramètres : 
	*		$pers : la personnes
	* Retourne un entier si la personne est un étudiant, 0 sinon
	*/
	public function estEtudiant($num){
		$sql = 'SELECT COUNT(*) as total FROM etudiant AS total WHERE per_num ="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ);
		return $result->total;
	}

	/*
	* Fonction qui permet de savoir si une personne est un salarié
	* Paramètres : 
	*		$pers = la personnes
	* Retourne un entier si la personne est un salarié, 0 sinon
	*/
	public function estSalarie($num){
		$sql = 'SELECT COUNT(*) as total FROM salarie AS total WHERE per_num ="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ);
		return $result->total;
	}

	/*
	* Fonction qui vérifie si une personne existe
	* Paramètres :
	*		$login : le login de la personne
	*		$mdp : le mot de passe de la personne
	* Retourne vrai si la personne existe, faux sinon
	*/
	public function existePers($login, $mdp){
		$sql='SELECT * FROM personne WHERE per_login="'.$login.'" AND per_pwd="'.$mdp.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch();
		if(empty($result)){
			return false;
		} else {
			return true;
		}
	}

	/*
	* Fonction qui récupère l'id d'une personne par son login
	* Paramètres : 
	*		$login : le login de la personne
	* Retourne l'id de la personne
	*/
	public function getIdByLogin($login){
		$sql='SELECT per_num FROM personne WHERE per_login="'.$login.'"';
		$req = $this->db->query($sql);
		$id = $req->fetch(PDO::FETCH_OBJ);
		return $id->per_num;
	}

	/*
	* Fonction qui modifie une personne
	* Paramètres : 
	* 		$pers : la personne à modifier
	*/
	public function modifierPers($pers){
		$sql = "UPDATE personne SET per_nom='".$pers->getPer_nom()."', per_prenom='".$pers->getPer_prenom()."', per_tel='".$pers->getPer_tel()."', per_mail='".$pers->getPer_mail()."', per_login='".$pers->getPer_login()."', per_pwd='".$pers->getPer_pwd()."' WHERE per_num=".$pers->getPer_num();
		$req = $this->db->prepare($sql);
		$result = $req->execute();
		return $result;
	}

	/*
	* Fonction qui permet de supprimer une personne par son numéro
	* Paramètres : 
	*		$num : le numéro de la personne à supprimer
	*/
	public function supprimerPers($num){
		$sql='DELETE FROM propose WHERE per_num="'.$num.'"';
		$req=$this->db->prepare($sql);
		$req->execute();

		$sql1='DELETE FROM avis WHERE per_num="'.$num.'"';
		$req=$this->db->prepare($sql1);
		$req->execute();

		$sql2='DELETE FROM personne WHERE per_num="'.$num.'"';
		$req=$this->db->prepare($sql2);
		$req->execute();
	}
}
