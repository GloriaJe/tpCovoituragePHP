<?php
class EtudiantManager{

    public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeEtudiant = array();

		$sql = 'SELECT per_num, dep_num, div_nom FROM etudiant';
		$req = $this->db->query($sql);
		while($etudiant = $req->fetch(PDO::FETCH_OBJ)){
			$listeEtudiant[] = new Etudiant($etudiant);
		}
		return $listeEtudiant;
		$req->closeCursor();
	}

    /*
	* Fonction permettant d'ajouter un étudiant dans la base de données
	* Paramètres :
	*		$etudiant : l'étudiant à ajouter
	*/
	public function add($etudiant){
		$req = $this->db->prepare('INSERT INTO etudiant (per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num)');
		$req->bindValue(':per_num', $etudiant->getPer_num(), PDO::PARAM_STR);
		$req->bindValue(':dep_num', $etudiant->getDep_num(), PDO::PARAM_STR);
		$req->bindValue(':div_num', $etudiant->getDiv_num(), PDO::PARAM_STR);
		$req->execute();
	}

	/*
	* Fonction qui permet de récupérer le département de l'étudiant avec son numero'
	* Paramètres : 
	*		$num = le numero de l'étudiant
	* Retourne le département de l'étudiant
	*/
	public function getDepByNum($num){
		$sql = 'SELECT dep_nom FROM departement WHERE dep_num="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->dep_nom;
		return $result;
	}

	/*
	* Fonction qui permet de récupérer le nom de la ville correspondant au numero de département
	* Paramètres : 
	*		$num : le numéro de département
	* Retourne le nom de la ville
	*/
	public function getVilleByDepNum($num){
		$sql = 'SELECT vil_nom FROM ville WHERE vil_num IN (SELECT vil_num FROM departement WHERE dep_num="'.$num.'")';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->vil_nom;
		return $result;
	}

	/*
	* Fonction qui permet de récupérer le numero du departement correspondant au numero de la ville
	* Paramètres : 
	*		$num : le numéro de la ville
	* Retourne le numero du département
	*/
	public function getDepNumByNum($num){
		$sql = 'SELECT dep_num FROM etudiant WHERE per_num="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->dep_num;
		return $result;
	}

	/*
	* Fonction qui permet de supprimer un etudiant par son numéro
	* Paramètres : 
	*		$num : le numéro de l'étudiant à supprimer
	*/
	public function supprimerEtu($num){
		$sql='DELETE FROM etudiant WHERE per_num="'.$num.'"';
		$req=$this->db->prepare($sql);
		$req->execute();
	}
}