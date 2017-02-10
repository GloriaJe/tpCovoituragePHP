<?php
class Salarie{

	private $per_num;
	private $sal_telprof;
	private $fon_num;

	public function __construct($valeurs = array()){

		if(!empty($valeurs)){
			$this ->affecte($valeurs);
		}
	}

	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur){
			switch($attribut){
				case 'per_num' : $this->setPer_num($valeur);
				break;

				case 'sal_telprof' : $this->setSal_telprof($valeur);
				break;

				case 'fon_num' : $this->setFon_num($valeur);
				break;
			}
		}
	}

	public function getPer_num(){
		return $this->per_num;
	}

	public function setPer_num($per_num){
		//controle des valeurs
		$this->per_num = $per_num;
	}

	public function getSal_telprof(){
		return $this->sal_telprof;
	}

	public function setSal_telprof($sal_telprof){
		//controle des valeurs
		$this->sal_telprof = $sal_telprof;
	}

	public function getFon_num(){
		return $this->fon_num;
	}

	public function setFon_num($fon_num){
		//controle des valeurs
		$this->fon_num = $fon_num;
	}
}
