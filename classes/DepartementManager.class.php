<?php
class DepartementManager{

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeDep = array();

		$sql = 'SELECT dep_num, dep_nom, vil_num FROM departement';
		$req = $this->db->query($sql);
		while($dep = $req->fetch(PDO::FETCH_OBJ)){
			$listeDep[] = new Departement($dep);
		}
		return $listeDep;
		$req->closeCursor();
	}
}
