<?php
class FonctionManager{

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeFonction = array();

		$sql = 'SELECT fon_num, fon_libelle FROM fonction';
		$req = $this->db->query($sql);
		while($fonction = $req->fetch(PDO::FETCH_OBJ)){
			$listeFonction[] = new Fonction($fonction);
		}
		return $listeFonction;
		$req->closeCursor();
	}
}
