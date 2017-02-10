<?php
class SalarieManager{

    public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeSalarie = array();

		$sql = 'SELECT per_num, sal_telprof, fon_num FROM salarie';
		$req = $this->db->query($sql);
		while($salarie = $req->fetch(PDO::FETCH_OBJ)){
			$listeSalarie[] = new Salarie($salarie);
		}
		return $listeSalarie;
		$req->closeCursor();
	}	

    /*
	* Fonction permettant d'ajouter un salarié dans la base de données
	* Paramètres :
	*		$salarie : le salarié à ajouter
	*/
	public function add($salarie){
		$req = $this->db->prepare('INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num)');
		$req->bindValue(':per_num', $salarie->getPer_num(), PDO::PARAM_STR);
		$req->bindValue(':sal_telprof', $salarie->getSal_telprof(), PDO::PARAM_STR);
		$req->bindValue(':fon_num', $salarie->getFon_num(), PDO::PARAM_STR);
		$req->execute();
	}

	/*
	* Fonction permettant de récupérer le numero pro d'un salarie par son numero
	* Paramètres : 
	*		$num = le numero du salarié
	* Retourne le numero pro du salarié
	*/
	public function getTelproByPerNum($num){
		$sql = 'SELECT sal_telprof FROM salarie WHERE per_num="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->sal_telprof;
		return $result;
	}

	/*
	* Fonction qui permet de récupérer le numéro de la fonction d'un salarié'
	* Paramètres : 
	*		$num : le numéro du salarié
	* Retourne le numéro de la fonction du salarié
	*/
	public function getFonctionByNum($num){
		$sql = 'SELECT fon_num FROM salarie WHERE per_num="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->fon_num;
		return $result;
	}

	/*
	* Fonction qui permet de récupérer la fonction d'un salarié'
	* Paramètres : 
	*		$num : le numéro de la fonction du salarié
	* Retourne la fonction du salarié
	*/
	public function getFonctionByFonNum($num){
		$sql = 'SELECT fon_libelle FROM fonction WHERE fon_num="'.$num.'"';
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_OBJ)->fon_libelle;
		return $result;
	}

	/*
	* Fonction qui permet de supprimer un salarié par son numéro
	* Paramètres : 
	*		$num : le numéro du salarié à supprimer
	*/
	public function supprimerSal($num){
		$sql='DELETE FROM salarie WHERE per_num="'.$num.'"';
		$req=$this->db->prepare($sql);
		$req->execute();
	}
}