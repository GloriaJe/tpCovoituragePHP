<?php
$db = new Mypdo();
$managerPers = new PersonneManager($db);
$listePers = $managerPers->getList();

if(empty($_POST["pers"]) && empty($_POST["verifLogin"]) && empty($_POST["nom"])){ ?>

    <h1> Supprimer une personne</h1>
    <form action="#" method="post">
        <label for="pers">Nom : </label>
        <select name="pers" class="champ">
            <?php
            foreach($listePers as $pers){ ?>
                <option value ="<?php echo $pers->getPer_num()?>">
                    <?php
                    echo $pers->getPer_prenom().' ';
                    echo $pers->getPer_nom();
                    ?>
                </option>
            <?php
            } ?>
        </select><br>
        <input type="submit" class="bouton" value="Valider">
    </form>
<?php
}

if(!empty($_POST["pers"]) && empty($_POST["verifLogin"])){

    $_SESSION["persModif"] = $managerPers->getPersById($_POST["pers"]);?>

    <h1>Saisir les informations d'authentification</h1>
    <form method="post" action="#">
        <label for="verifLogin">Login de <?php echo $_SESSION["persModif"]->getPer_prenom().' '.$_SESSION["persModif"]->getPer_nom()?></label>
        <input type="text" class="champ" name="verifLogin" size=15 required>
        <br>
        <label for="verifPwd">Mot de passe de <?php echo $_SESSION["persModif"]->getPer_prenom().' '. $_SESSION["persModif"]->getPer_nom()?></label>
        <input type="password" class="champ" name="verifPwd" size=15 required>
        <br>
        <input type="submit" class="bouton" value="Valider">
    </form>
<?php
}

if(!empty($_POST["verifLogin"]) && empty($_POST["pers"])){

    $login = $_SESSION["persModif"]->getPer_login();
    $mdp = $_SESSION["persModif"]->getPer_pwd();

    $login2 = $_POST["verifLogin"];
    $mdp2 = $_POST["verifPwd"];
    $mdp2C =  sha1(sha1($mdp2).$salt);

    if($login == $login2 && $mdp == $mdp2C){

        $managerEtu = new EtudiantManager($db);
        $managerSal = new SalarieManager($db);

        if($managerPers->estEtudiant($_SESSION["persModif"]->getPer_num())){
            $managerEtu->supprimerEtu($_SESSION["persModif"]->getPer_num());
        } else {
            $managerSal->supprimerSal($_SESSION["persModif"]->getPer_num());
        }
        
        $managerPers->supprimerPers($_SESSION["persModif"]->getPer_num());

        //on déconnecte la personne supprimée
        unset($_SESSION["login"]);
        ?>
        <p><img alt="ok" src="image/valid.png"> La personne a bien été supprimée !</p>
        <?php

    } else {  ?>

        <p><img src="image/erreur.png" alt="image erreur"> Mauvais login/mot de passe !</p>
        <?php
        }
}
?>
