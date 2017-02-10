<h1>Proposer un trajet</h1>
<?php
include_once('include /functions.inc.php');
$db = new Mypdo();
$managerVille = new VilleManager($db);
$managerPro = new ProposeManager($db);
$listeVilleDep = $managerPro->getVilleParcours();

if(empty($_SESSION["login"])){
    echo "Vous devez être connecté pour acceder à cette page !";
}

if(empty($_POST["villeDep"])) { ?>
    <form name="proposeTrajet" method="post">
        <label for="villeDep">Ville de départ : </label>
        <select name="villeDep" class="champ">
            <?php
            foreach($listeVilleDep as $ville){ ?>
                <option value ="<?php echo $ville->getVil_num()?>">
                    <?php
                    echo $ville->getVil_nom();
                    ?>
                </option>
            <?php
            } ?>
        </select>
        <input type="submit" class="bouton" value="Valider">
    </form>
<?php
} 

if(!empty($_POST["villeDep"]) && empty($_POST["villeArr"])) { 
    $_SESSION["villeDep"] = $_POST["villeDep"];
    $listeVilleArr = $managerPro->getVilleArrive($_POST["villeDep"]); 
    $villeDepart = $managerVille->getVilNomById($_POST["villeDep"]); ?>
    <form name="detailPropose" method="post">
        <label for="villeDep">Ville de départ : <?php echo $villeDepart?></label>
        <label for="villaArr">Ville d'arrivée : </label>
        <select name="villeArr" class="champ">
        <?php
        foreach($listeVilleArr as $ville){ ?>
            <option value ="<?php echo $ville->getVil_num()?>">
                <?php
                echo $ville->getVil_nom();
                ?>
            </option>
        <?php
        } ?>
        </select><br>
        <label for="dateDep">Date de départ :</label>
        
        <!-- Tableau : calendrier javascript -->
		<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
			<tr>
				<td id="ds_calclass"></td>
			</tr>
		</table>
		<!-- Les champs texte avec le code "onclick" déclenchant le script -->
		<input type="text" name="dateDep" class="champ" onclick="ds_sh(this);" />

        <label for="heureDep">Heure de départ :</label>
        <input type="time" class="champ" name="heureDep" value="<?php echo date("H:i") ?>"><br>
        <label for="nbPlaces">Nombre de places :</label>
        <input type="number" class="champ" name="nbPlaces" value=1 min=1><br>
        <input type="submit" class="bouton" value="valider">
    </form>
<?php              
} 

if(empty($_POST["villeDep"]) && !empty($_POST["villeArr"])) {
    $managerPers = new PersonneManager($db);
    $managerParcours = new ParcoursManager($db);
    $par_num = $managerParcours->getIdParcoursByVille($_SESSION["villeDep"], $_POST["villeArr"]);
    $per_num = $managerPers->getIdByLogin($_SESSION["login"]);
    $sens=$managerParcours->getSens($_SESSION["villeDep"], $_POST["villeArr"]);
    $trajet = new Propose(array('par_num'=>$par_num, 'per_num'=>$per_num, 'pro_date'=>getEnglishDate($_POST['dateDep']), 'pro_time'=>$_POST["heureDep"], 'pro_place'=>$_POST["nbPlaces"], 'pro_sens'=>$sens));
    $message = "Ajout trajet";
    $managerPro->add($trajet);
    ?>
    <p><img alt="ok" src="image/valid.png"> Trajet ajouté !</p>
    <?php
}
?>
