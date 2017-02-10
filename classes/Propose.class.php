<?php
class Propose{

    private $par_num;
    private $per_num;
    private $pro_date;
    private $pro_time;
    private $pro_place;
    private $pro_sens;

    public function __construct($valeurs = array()){

        if(!empty($valeurs)){
            $this ->affecte($valeurs);
        }
    }

    public function affecte($donnees){
        foreach ($donnees as $attribut => $valeur){
            switch($attribut){
                case 'par_num' : $this->setPar_num($valeur);
                break;

                case 'per_num' : $this->setPer_num($valeur);
                break;

                case 'pro_date' : $this->setPro_date($valeur);
                break;

                case 'pro_time' : $this->setPro_time($valeur);
                break;

                case 'pro_place' : $this->setPro_place($valeur);
                break;

                case 'pro_sens' : $this->setPro_sens($valeur);
                break;
            }
        }
    }

    public function getPar_num(){
		return $this->par_num;
	}

	public function setPar_num($par_num){
		//TODO: controle des valeurs
		$this->par_num=$par_num;
	}

    public function getPer_num(){
        return $this->per_num;
    }

    public function setPer_num($per_num){
        //TODO : controle des valeurs
        $this->per_num=$per_num;
    }

    public function getPro_date(){
        return $this->pro_date;
    }

    public function setPro_date($pro_date){
        //TODO : controle des valeurs
        $this->pro_date=$pro_date;
    }

    public function getPro_time(){
        return $this->pro_time;
    }

    public function setPro_time($pro_time){
        //TODO : controle des valeurs
        $this->pro_time=$pro_time;
    }

    public function getPro_place(){
        return $this->pro_place;
    }

    public function setPro_place($pro_place){
        //TODO : controle des valeurs
        $this->pro_place=$pro_place;
    }

    public function getPro_sens(){
        return $this->pro_sens;
    }

    public function setPro_sens($pro_sens){
        //TODO : controle des valeurs
        $this->pro_sens=$pro_sens;
    }
}