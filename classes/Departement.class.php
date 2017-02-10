<?php
class Departement{


		private $dep_num;
		private $dep_nom;
		private $vil_num;

		public function __construct($valeurs = array()){

			if(!empty($valeurs)){
				$this ->affecte($valeurs);
			}
		}

		public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
				switch($attribut){
					case 'dep_num' : $this->setDep_num($valeur);
					break;

					case 'dep_nom' : $this->setDep_nom($valeur);
					break;

					case 'vil_num' : $this->setVil_num($valeur);
					break;
				}
			}
		}

		public function getDep_num(){
			return $this->dep_num;
		}

		public function setDep_num($dep_num){
			//controle des valeurs
			$this->dep_num = $dep_num;
		}

		public function getDep_nom(){
			return $this->dep_nom;
		}

		public function setDep_nom($dep_nom){
			//controle des valeurs
			$this->dep_nom = $dep_nom;
		}

		public function getVil_num(){
			return $this->vil_num;
		}

		public function setVil_num($vil_num){
			//controle des valeurs
			$this->vil_num = $vil_num;
		}

}
