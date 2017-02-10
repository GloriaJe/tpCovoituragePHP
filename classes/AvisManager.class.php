<?php
class AvisManager{

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeAvis = array();

		$sql = 'SELECT per_num, per_per_num, par_num, avi_comm, avi_note, avi_date FROM avis';
		$req = $this->db->query($sql);
		while($avis = $req->fetch(PDO::FETCH_OBJ)){
			$listeAvis[] = new Avis($avis);
		}
		return $listeAvis;
		$req->closeCursor();
	}

    /*
	* Fonction qui récupère la moyenne des avis pour une personne
	* Paramètres : 
	*		$pers : le numéro de la personne
	* Retourne la moyenne des avis pour cette personne
	*/
	public function getMoyAvis($pers){
		$sql='SELECT AVG(avi_note) as moy FROM avis WHERE per_num="'.$pers.'"';
		$req=$this->db->query($sql);
		$moy=$req->fetch(PDO::FETCH_OBJ);
		return $moy->moy;
	}

	/*
	* Fonction qui récupère le dernier avis laissé sur une personne
	* Paramètres : 
	*	 	$pers : le numero de la personne
	* Retourne le dernier avis laisse sur cette personne
	*/
	public function getLastAvis($pers){
		$sql='SELECT * FROM avis WHERE per_num="'.$pers.'" ORDER BY avi_date DESC LIMIT 1';
		$req=$this->db->query($sql);
		$avis=$req->fetch(PDO::FETCH_OBJ);
		return $avis->avi_comm;
	}
}