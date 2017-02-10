<?php
class Departement{


		private $per_num;
		private $per_per_num;
		private $par_num;
        private $avi_comm;
        private $avi_note;
        private $avis_date;

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

					case 'per_per_num' : $this->setPer_per_num($valeur);
					break;

					case 'par_num' : $this->setPar_num($valeur);
					break;

                    case 'avi_comm' : $this->setAvi_comm($valeur);
					break;

                    case 'avi_note' : $this->setAvi_note($valeur);
					break;

                    case 'avis_date' : $this->setAvi_date($valeur);
					break;
				}
			}
		}

	public function getPer_num(){
		return $this->per_num;
	}

	public function setPer_num($per_num){
		$this->per_num = $per_num;
	}

	public function getPer_per_num(){
		return $this->per_per_num;
	}

	public function setPer_per_num($per_per_num){
		$this->per_per_num = $per_per_num;
	}

	public function getPar_num(){
		return $this->par_num;
	}

	public function setPar_num($par_num){
		$this->par_num = $par_num;
	}

	public function getAvi_comm(){
		return $this->avi_comm;
	}

	public function setAvi_comm($avi_comm){
		$this->avi_comm = $avi_comm;
	}

	public function getAvi_note(){
		return $this->avi_note;
	}

	public function setAvi_note($avi_note){
		$this->avi_note = $avi_note;
	}

	public function getAvis_date(){
		return $this->avis_date;
	}

	public function setAvis_date($avis_date){
		$this->avis_date = $avis_date;
	}
}