<?php
class DivisionManager{

	public function __construct($db){
		$this->db = $db;
	}

	public function getList(){
		$listeDivision = array();

		$sql = 'SELECT div_num, div_nom FROM division';
		$req = $this->db->query($sql);
		while($division = $req->fetch(PDO::FETCH_OBJ)){
			$listeDivision[] = new Division($division);
		}
		return $listeDivision;
		$req->closeCursor();
	}
}
