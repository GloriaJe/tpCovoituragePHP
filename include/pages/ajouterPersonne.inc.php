<?php
$db = new Mypdo();
$manager = new PersonneManager($db);
$managerDiv = new DivisionManager($db);
$managerDep = new DepartementManager($db);
$managerFon = new FonctionManager($db);
$managerEtu = new EtudiantManager($db);
$managerSal = new SalarieManager($db);

if(empty($_POST["nom"]) && empty($_POST["dep"]) && empty($_POST["fonction"]))
{
	?>
	<h1>Ajouter une personne</h1>
	<form name="personne" method="post">
		<label for="nom">Nom : </label>
		<input type="text" class="champ" name="nom" size=15 required>

		<label for="prenom">Prénom : </label>
		<input type="text" class="champ" name="prenom" size=15 required>
		<br>
		<label for="tel">Téléphone : </label>
		<input type="tel" class="champ" name="tel" size=15 required>

		<label for="mail">Mail : </label>
		<input type="email" class="champ" name="mail" size=15 required>
		<br>
		<label for="login">Login : </label>
		<input type="text" class="champ" name="login" size=15 required>

		<label for="pwd">Mot de passe : </label>
		<input type="password" class="champ" name="pwd" size=15 required>
		<br>
		<label for="categorie">Catégorie : </label>
		<input type="radio" name="categorie" value="Etudiant" checked>Etudiant
		<input type="radio" name="categorie" value="Personnel">Personnel
		<br>
		<input type="submit" class="bouton" value="Valider">
	</form>
	<?php
}

if(isset($_POST["nom"]) && empty($_POST["dep"]) && empty($_POST["fonction"])){
	$pwd = sha1(sha1($_POST["pwd"]).$salt);
	$_SESSION["newPersonne"] = new Personne(array('per_num'=>0, 'per_nom'=>$_POST["nom"], 'per_prenom'=>$_POST["prenom"], 'per_tel'=>$_POST["tel"], 'per_mail'=>$_POST["mail"], 'per_login'=>$_POST["login"], 'per_pwd'=>$pwd));
	$manager->add($_SESSION["newPersonne"]);

	if($_POST["categorie"] == "Etudiant"){
		?>
		<!--Formulaire d'ajout d'un étudiant-->
		<h1>Ajouter un étudiant</h1>

		<form method="post">
			<label for="division">Année : </label>
			<select name="annee" class="champ">
				<?php
				$listeDiv = $managerDiv->getList();
				foreach($listeDiv as $div){ ?>
					<option value ="<?php echo $div->getDiv_num()?>">
						<?php
						echo $div->getDiv_nom();
						?>
					</option>
				<?php
				} ?>
			</select>
			<br>
			<label for="dep">Département : </label>
			<select name="dep" class="champ">
				<?php
				$listeDep = $managerDep->getList();
				foreach($listeDep as $dep){ ?>
					<option value ="<?php echo $dep->getDep_num()?>">
						<?php
						echo $dep->getDep_nom();
						?>
					</option>
				<?php
				} ?>
			</select>
			<br>
			<input type="submit" class="bouton" value="Valider">
		<?php
		}
		else{
			//Formulaire d'ajout d'un salarié
			?>
			<h1>Ajouter un salarié</h1>

			<form method="post">
				<label for="tel">Téléphone professionnel :</label>
				<input type="text" name="tel" size=10 required>
				<br>
				<label for="fonction">Fonction :</label>
				<select name="fonction" class="champ">
					<?php
					$listeFon = $managerFon->getList();
					foreach($listeFon as $fon){ ?>
						<option value ="<?php echo $fon->getFon_num()?>">
							<?php
							echo $fon->getFon_lib();
							?>
						</option>
					<?php
					} ?>
				</select>
				<br>
				<input type="submit" class="bouton" value="Valider">
			</form>
		<?php
		}
}

if(empty($_POST["nom"]) && isset($_POST["dep"]) || isset($_POST["fonction"])){

	$last = $manager->getLastPers();

	if(isset($_POST["dep"])){

		//Ajout de l'étudiant
		$etudiant = new Etudiant(array('per_num'=>$last->getPer_num(), 'dep_num'=>$_POST["dep"], 'div_num'=>$_POST["annee"]));
		$managerEtu->add($etudiant);
        ?>
        <p><img alt="ok" src="image/valid.png"> Etudiant ajouté !</p>
        <?php

	} 

	if(isset($_POST["fonction"])){

		//Ajout du salarié
		$salarie = new Salarie(array('per_num'=>$last->getPer_num(), 'sal_telprof'=>$_POST["tel"], 'fon_num'=>$_POST["fonction"]));
		$managerSal->add($salarie);
        ?>
        <p><img alt="ok" src="image/valid.png"> Salarié ajouté !</p>
        <?php


	} 
}?>
