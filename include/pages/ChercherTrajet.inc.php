<h1>Rechercher un trajet</h1>
<?php
include_once('include /functions.inc.php');
$db = new Mypdo();
$managerPro = new ProposeManager($db);
$managerVille = new VilleManager($db);
$listeVilleDep = $managerPro->getVillesDep();

if(empty($_SESSION["login"])){
    echo "Vous devez être connecté pour acceder à cette page !";
}

if(empty($_POST["villeDep"]) && empty($_POST["villeArr"])){ ?>
    <form name="villeDep" method="post">
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
        </select><br>
        <input type="submit" class="bouton" value="Valider">
    </form>
<?php
}

if(!empty($_POST["villeDep"])){ 
    $villeDepart = $managerVille->getVilNomById($_POST["villeDep"]);
    $listeVilleArr = $managerPro->getVilleArrive($_POST["villeDep"]);
    $_SESSION["villeDep"] = $_POST["villeDep"]; ?>
    <form name="vileArr" method="post">
        <label for="villeDep">Ville de départ : <?php echo $villeDepart ?></label>
        <label for="villeArr">Ville d'arrivée :</label>
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

        <label for="precision">Précision :</label>
        <select name="precision" class="champ">
            <option value="0">
                <?php echo "Ce jour" ?>
            </option>
            <option value="1">
                <?php echo "+/- 1 jours"?>
            </option>
            <option value="2">
                <?php echo "+/- 2 jours" ?>
            </option>
            <option value="3">
                <?php echo "+/- 3 jours" ?>
            </option>
        </select><br>
        <label for="heure">A partir de :</label>
        <select name="heure" class="champ">
            <?php for($i=0; $i<24; $i++){?>
            <option value="<?php echo $i ?>">
                <?php echo $i ."h" ?>
            </option>
            <?php
            }?>
        </select><br>
        <input type="submit" class="bouton" value="Valider">        
    </form>
    <?php
} 

if(empty($_POST["villeDep"]) && !empty($_POST["villeArr"])){

    $managerParcours = new ParcoursManager($db);
    $managerPersonne = new PersonneManager($db);
    $managerAvis = new AvisManager($db);
    $par_num = $managerParcours->getIdParcoursByVille($_SESSION["villeDep"], $_POST["villeArr"]);
    $sens = $managerParcours->getSens($_SESSION["villeDep"], $_POST["villeArr"]);
    $listeTrajets = $managerPro->getTrajets($par_num, $sens, getEnglishDate($_POST["dateDep"]), $_POST["heure"], $_POST["precision"]);
    
    if($listeTrajets == null){ ?>
        <p><img src="image/erreur.png" alt="image erreur"> Aucun trajet correspondant !</p>
    <?php
    } else { ?>

        <table>
            <tr>
                <th>Ville départ</th>
                <th>Ville arrivéeNom</th>
                <th>Date départ</th>
                <th>Heure départ</th>
                <th>Nombre de place(s)</th>
                <th>Nom du covoitureur</th>
            </tr>
        <?php
        foreach($listeTrajets as $trajet){ 
            $pers = $managerPersonne->getPersById($trajet->per_num) ?>
            <tr>
                <td><?php echo $_SESSION["villeDep"] ?></td>
                <td><?php echo $_POST["villeArr"] ?></td>
                <td><?php echo getFrenchDate($trajet->pro_date) ?></td>
                <td><?php echo $trajet->pro_time ?></td>
                <td><?php echo $trajet->pro_place ?></td>
                <td>
                    <a href="#" class="infos">
                        <?php echo $pers->getPer_prenom()." ".$pers->getPer_nom() ?>
                        <span>
                            Moyenne des avis : <?php echo $managerAvis->getMoyAvis($pers->getPer_num())?><br>
                            Dernier avis : <?php echo $managerAvis->getLastAvis($pers->getPer_num())?>
                        </span>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
        </table>
    <?php
    } ?>

<?php
}
?>
