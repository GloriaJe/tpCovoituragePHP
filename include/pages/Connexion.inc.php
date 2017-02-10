<h1>Pour vous connecter</h1>

<?php
$db = new Mypdo();
$manager = new PersonneManager($db);
//Si l'utilisateur n'a rien rempli
if(empty($_POST["username"]) && empty($_POST["mdp"]) && empty($_POST["result"])){
?>

    <form name="connexion" method = "post">
        <label for="username">Nom d'utilisateur : </label><br>
        <input type="text" class="champ" name="username" id="username"><br>
        <label for="mdp">Mot de passe : </label><br>
        <input type="password" class="champ" name="mdp" id="mdp"><br>

        <?php

        $image1 = rand(1,9);
        $image2 = rand(1,9);

        ?>
        <img class="nb" src="image/nb/<?php echo $image1?>.jpg">
        <?php echo "+" ?>
        <img class="nb" src="image/nb/<?php echo $image2?>.jpg">
        <?php echo "=" ?><br>

        <input type="text" class="champ" name="result" id="result"><br>
        <input type="submit" class="bouton" value="Valider">

        <?php $_SESSION["result"]=$image1 + $image2 ?>
    </form>
<?php
//Si le resultat ne correspond pas au resultat attendu
} else if($_POST["result"] != $_SESSION["result"]){

    echo "erreur, connexion impossible";
//Si le resultat correspond au resultat attendu
} else {
    $salt="48@!alsd";

    $verif=$manager->existePers($_POST["username"], sha1(sha1($_POST["mdp"]).$salt));

    //Si la personne existe
    if($verif){
        header("location: ./index.php");
        $_SESSION["login"] = $_POST["username"];
    //Sinon, on affiche une erreur
    } else {
        echo "Erreur - mauvais login/mot de passe";
    }
}

