<?php
class ProposeManager{

    public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listePropose = array();

		$sql = 'SELECT par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM propose';
		$req = $this->db->query($sql);
		while($propose = $req->fetch(PDO::FETCH_OBJ)){
			$listePropose[] = new Propose($propose);
		}
		return $listePropose;
		$req->closeCursor();
	}

    /*
	* Fonction permettant d'ajouter un trajet proposé dans la base de données
	* Paramètres :
	*		$propose : le trajet proposé
	*/
	public function add($trajet){
		$req = $this->db->prepare('INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:par_num, :per_num, :pro_date, :pro_time, :pro_place, :pro_sens)');
		$req->bindValue(':par_num', $trajet->getPar_num(), PDO::PARAM_STR);
		$req->bindValue(':per_num', $trajet->getPer_num(), PDO::PARAM_STR);
		$req->bindValue(':pro_date', $trajet->getPro_date(), PDO::PARAM_STR);
        $req->bindValue(':pro_time', $trajet->getPro_time(), PDO::PARAM_STR);
        $req->bindValue(':pro_place', $trajet->getPro_place(), PDO::PARAM_STR);
        $req->bindValue(':pro_sens', $trajet->getPro_sens(), PDO::PARAM_STR);
		$req->execute();
	}

    /*
    * Fonction qui récupère les villes référencées dans la table parcours
    */
    public function getVilleParcours(){
        $listeVilles = array();
        $sql='SELECT vil_nom, vil_num FROM ville WHERE vil_num IN (SELECT vil_num1 FROM parcours) OR vil_num IN (SELECT vil_num2 FROM parcours)';
        $req = $this->db->query($sql);
        while($result = $req->fetch(PDO::FETCH_OBJ)){
            $listeVilles[] = new Ville($result);
        }
        return $listeVilles;
        $req->closeCursor();
    }

	/*
	* Fonction qui récupère les villes d'arrivée disponibles pour une ville de départ
	* Paramètres : 
	*		$villeDep : la ville de départ
	* Retourne les villes d'arrivée disponibles
	*/
	public function getVilleArrive($villeDep){
		$listeVillesArr = array();
		$sql='SELECT vil_nom, vil_num FROM ville WHERE vil_num IN(SELECT vil_num1 FROM parcours WHERE vil_num2 ="'.$villeDep.'") OR vil_num IN(SELECT vil_num2 FROM parcours WHERE vil_num1 ="'.$villeDep.'")';
        $req = $this->db->query($sql);
        while($result = $req->fetch(PDO::FETCH_OBJ)){
            $listeVillesArr[] = new Ville($result);
        }
        return $listeVillesArr;
        $req->closeCursor();
	}

	/*
	* Fonction qui récupère les villes de départ
	* Retourne : les villes de départ
	*/
	public function getVillesDep(){
		$listeVillesDep=array();
		$sql='SELECT vil_nom, vil_num FROM ville WHERE vil_num IN (SELECT vil_num1 FROM parcours par JOIN propose pro ON par.par_num = pro.par_num WHERE pro_sens = 0 UNION SELECT vil_num2 FROM parcours par JOIN propose pro ON par.par_num = pro.par_num WHERE pro_sens=1)';
		$req = $this->db->query($sql);
		while($result = $req->fetch(PDO::FETCH_OBJ)){
			$listeVillesDep[] = new Ville($result);
		}
		return $listeVillesDep;
	}

	/*
	* Fonction qui retourne le tableau des trajets correspondant à la recherche
	* Paramètres :
	* 		$parcours  : le parcours 
	*		$sens      : le sens du parcours
	*		$date      : la date de départ
	*		$heure     : l'heure à partir de laquelle on recherche
	*		$precision : la précision (intervalle pour la date)
	* Retourne un tableau contenant les informations sur les trajets correspondants
	*/
	public function getTrajets($parcours, $sens, $date, $heure, $precision){
		$listeTrajets=array();
		$sql="SELECT pro_date, pro_time, pro_place, per_num FROM propose WHERE par_num='".$parcours."' AND pro_time >'".$heure."' AND pro_sens='".$sens."' AND pro_date BETWEEN '".addPrecision($date, -$precision)."' AND '".addPrecision($date, +$precision)."'";
		$req = $this->db->query($sql);
		while($result = $req->fetch(PDO::FETCH_OBJ)){
			$listeTrajets[] = $result;
		}
		return $listeTrajets;
	}
}