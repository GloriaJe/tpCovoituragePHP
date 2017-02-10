<h1>Ajouter un parcours</h1>

<?php
$db = new Mypdo();
$manager = new ParcoursManager($db);
$managerVille = new VilleManager($db);
$listeVille = $managerVille->getList();

if(empty($_POST["ville1"]) || empty($_POST["ville2"]) || empty($_POST["nb_km"])){
    ?>
    <form name="parcours" method="post">
        <label for="ville1">Ville 1: </label>
        <select name="ville1" class="champ">
            <?php
            foreach($listeVille as $ville){ ?>
                <option value ="<?php echo $ville->getVil_num()?>">
                    <?php
                    echo $ville->getVil_nom();
                    ?>
                </option>
            <?php
            } ?>
        </select>

        <label for="ville2">Ville 2: </label>
        <select name="ville2" class="champ">
            <?php
            foreach($listeVille as $ville){ ?>
                <option value ="<?php echo $ville->getVil_num()?>">
                    <?php
                    echo $ville->getVil_nom();
                    ?>
                </option>
            <?php
            } ?>
        </select>

        <label for="nb_km">Nombre de kilomètre(s)</label>
        <input type="text" class="champ" name="nb_km" size="5"><br><br>
        <input type="submit" class="bouton" value="valider">
    </form>
<?php
} else {
    $parcours = new Parcours(array('par_km'=>$_POST['nb_km'], 'vil_num1'=>$_POST['ville1'], 'vil_num2'=>$_POST['ville2']));
    $message = "ajout parcours";
    $manager->add($parcours);
    ?>
    <p><img alt="ok" src="image/valid.png"> Le parcours a été ajouté !</p>
    <?php

}?>
