<?php
class ParcoursManager{

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeParcours = array();

		$sql = 'SELECT par_num, vil_num1, vil_num2, par_km FROM parcours';
		$req = $this->db->query($sql);
		while($parcours = $req->fetch(PDO::FETCH_OBJ)){
			$listeParcours[] = new Parcours($parcours);
		}
		return $listeParcours;
		$req->closeCursor();
	}

	/*
	* Fonction permettant d'ajouter un parcours dans la base de données
	* Paramètres :
	*		$parcours : le parcours à ajouter
	*/
	public function add($parcours){
		$req = $this->db->prepare('INSERT INTO parcours (par_km, vil_num1, vil_num2) VALUES (:par_km, :vil_num1, :vil_num2)');
		$req->bindValue(':par_km', $parcours->getPar_km(), PDO::PARAM_STR);
		$req->bindValue(':vil_num1', $parcours->getVil_num1(), PDO::PARAM_STR);
		$req->bindValue(':vil_num2', $parcours->getVil_num2(), PDO::PARAM_STR);
		$req->execute();
	}

	/*
	* Fonction qui retourne le nombre de parcours
	*/
	public function getNb(){
		$sql = 'SELECT COUNT(*) AS total FROM parcours';
		$req = $this->db->query($sql);
		$nb = $req->fetch(PDO::FETCH_OBJ);
		return $nb->total;
	}

	/*
	* Fonction qui récupère le numéro d'un parcours pour une ville de départ et une ville d'arrivée données
	* Paramètres : 
	*		$ville1 : la première ville
	*		$ville2 : la deuxième ville
	* Retourne : le numéro du parcours correspondant
	*/
	public function getIdParcoursByVille($ville1, $ville2){
		$sql='SELECT par_num FROM parcours WHERE vil_num1 = "'.$ville1.'" AND vil_num2 = "'.$ville2.'" OR vil_num1 = "'.$ville2.'" AND vil_num2 = "'.$ville1.'"';
		$req = $this->db->query($sql);
		$id=$req->fetch(PDO::FETCH_OBJ);
		return $id->par_num;
	}

	/*
	* Fonction qui détermine le sens d'un parcours 
	* Paramètres : 
	*		$villeDep : la ville de départ
	*		$villeArr : la ville d'arrivée
	* Retourne le sens du parcours
	*/
	public function getSens($villeDep, $villeArr){
		$sql='SELECT COUNT(*) as sens FROM parcours WHERE vil_num1 ="'.$villeArr.'" AND vil_num2 ="'.$villeDep.'"';
		$req=$this->db->query($sql);
		$sens=$req->fetch(PDO::FETCH_OBJ);
		return $sens->sens;
	}
}
