<?php
$db = new Mypdo();
$managerPers = new PersonneManager($db);
$listePers = $managerPers->getList();

if(empty($_POST["pers"]) && empty($_POST["verifLogin"]) && empty($_POST["nom"])){ ?>

    <h1> Modifier une personne</h1>
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

        $_SESSION["ok"] = true; ?>

        <h1>Modification de <?php echo $_SESSION["persModif"]->getPer_prenom().' '.$_SESSION["persModif"]->getPer_nom()?></h1>
        <form action="#" method="post">
            <label for="nom">Nom : </label>
            <input type="text" class="champ" name="nom" size=15 value="<?php echo $_SESSION["persModif"]->getPer_nom()?>" required>

            <label for="prenom">Prénom : </label>
            <input type="text" class="champ" name="prenom" size=15 value="<?php echo $_SESSION["persModif"]->getPer_prenom()?>" required>
            <br>
            <label for="tel">Téléphone : </label>
            <input type="tel" class="champ" name="tel" size=15 value="<?php echo $_SESSION["persModif"]->getPer_tel()?>" required>

            <label for="mail">Mail : </label>
            <input type="email" class="champ" name="mail" size=15  value="<?php echo $_SESSION["persModif"]->getPer_mail()?>" required>
            <br>
            <label for="login">Login : </label>
            <input type="text" class="champ" name="login" size=15  value="<?php echo $_SESSION["persModif"]->getPer_login()?>" required>
            <br>
            
            <label for="pwd">Nouveau mot de passe :</label>
            <input type="password" class="champ" name="pwd" size=15>
            <br>
            <input type="submit" class="bouton" value="Valider">
        </form>
    <?php
    } else { 

        $_SESSION["ok"] = false; ?>
        <p><img src="image/erreur.png" alt="image erreur"> Mauvais login/mot de passe !</p>
    <?php
    }
}

if(!empty($_POST["nom"]) && $_SESSION["ok"]=true){

    $mdpCrypte = sha1(sha1($_POST["pwd"]).$salt);
    $pers = new Personne(array('per_num'=>$_SESSION["persModif"]->getPer_num(), 'per_nom'=>$_POST["nom"], 'per_prenom'=>$_POST["prenom"], 'per_tel'=>$_POST["tel"], 'per_mail'=>$_POST["mail"], 'per_login'=>$_POST["login"], 'per_pwd'=>$mdpCrypte));
    $managerPers->modifierPers($pers);
    ?>
    <p><img alt="ok" src="image/valid.png">La personne a bien été modifiée !</p>

<?php    
}
?>

