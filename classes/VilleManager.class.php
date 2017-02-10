<?php
class VilleManager{

	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeVille = array();

		$sql = 'SELECT vil_num, vil_nom FROM ville ORDER BY vil_nom ASC';
		$req = $this->db->query($sql);
		while($ville = $req->fetch()){
			$listeVille[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVille;
	}

	/*
	* Fonction permettant d'ajouter une ville dans la base de données
	* Paramètres :
	*		$ville : la ville à ajouter
	*/
	public function add($ville){
		$req = $this->db->prepare('INSERT INTO ville (vil_nom) VALUES (:vil_nom)');
		$req->bindValue(':vil_nom', $ville->getVil_nom());
		$req->execute();
	}

	/*
	* Fonction qui retourne le nombre de villes différentes
	*/
	public function getNb(){
		$sql = 'SELECT COUNT(DISTINCT vil_nom) AS total FROM ville';
		$req = $this->db->query($sql);
		$nb = $req->fetch(PDO::FETCH_OBJ);
		return $nb->total;
	}

	/*
	* Fonction qui permet de recupérer le nom d'une ville par son numéro
	*/
	public function getVilNomById($id){
		$sql = 'SELECT vil_nom FROM ville WHERE vil_num = "'.$id.'"';
		$req = $this->db->query($sql);
		$nom = $req->fetch(PDO::FETCH_OBJ);
		return $nom->vil_nom;
	}

}
