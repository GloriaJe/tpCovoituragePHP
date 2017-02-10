<h1>Ajouter une ville</h1>

<?php
$db = new Mypdo();
$manager = new VilleManager($db);

if(empty($_POST["ville"])){
    ?>
    <form name="nom_ville" method = "post">
        <label for="nom_ville">Nom : </label>
        <input type="text" class="champ" name="ville" id="ville">
        <input type="submit" class ="bouton" value="Valider">
    </form>
<?php
} else {
    $ville = new Ville(array('vil_nom'=>$_POST['ville']));
    $message = "ajout ville";
    $manager->add($ville);
    ?>
    <p><img alt="ok" src="image/valid.png"> La ville <b><?php echo $_POST["ville"] ?></b> a été ajoutée !</p>
    <?php
}
?>
