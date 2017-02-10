<?php
$db = new Mypdo();
$manager = new PersonneManager($db);
if(empty($_GET["num"])){?>


  <h1>Liste des personnes enregistrées</h1>
  <p>Actuellement <?php echo $manager->getNb(); ?> personnes sont enregistrées</p>
  <table>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
    <th>Prénom</th>
  </tr>
  <?php
  $listePersonne = $manager->getList();

  foreach($listePersonne as $personne){  ?>
    <tr>
      <td><a href="http://localhost/php/TP3/index.php?page=2&amp;num=<?php echo $personne->getPer_num()?>"><?php echo $personne->getPer_num(); ?></a></td>
      <td><?php echo $personne->getPer_nom(); ?></td>
      <td><?php echo $personne->getPer_prenom(); ?></td>
    </tr>
  <?php
  }
  ?>
</table>
<?php
} else {

  $personne = $manager->getPersById($_GET["num"]);
  $nom = $personne->getPer_nom();
  $prenom = $personne->getPer_prenom();
  $mail = $personne->getPer_mail();
  $tel = $personne->getPer_tel();

  if($manager->estEtudiant($_GET["num"]) != 0){

    $managerEtu = new EtudiantManager($db);
    $numDep = $managerEtu->getDepNumByNum($_GET["num"]);
    $dep = $managerEtu->getDepByNum($numDep);
    $ville = $managerEtu->getVilleByDepNum($numDep);

    ?>

    <h1>Détail sur l'étudiant <?php echo $nom ?></h1>

    <table>
      <tr>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Tel</th>
        <th>Département</th>
        <th>Ville</th>
      </tr>
      <tr>
        <th><?php echo $prenom ?></th>
        <th><?php echo $mail ?></th>
        <th><?php echo $tel ?></th>
        <th><?php echo $dep ?></th>
        <th><?php echo $ville ?></th>
      </tr>
    </table>
    <?php
  }
  
  if($manager->estSalarie($_GET["num"]) != 0){

    $managerSal = new SalarieManager($db);
    $telpro = $managerSal->getTelproByPerNum($_GET["num"]);
    $fonNum = $managerSal->getFonctionByNum($_GET["num"]);
    $fonction = $managerSal->getFonctionByFonNum($fonNum);

    //récupérer telpro et fonction du salarié

        ?>

    <h1>Détail sur le salarié <?php echo $nom ?></h1>

    <table>
      <tr>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Tel</th>
        <th>Telpro</th>
        <th>Fonction</th>
      </tr>
      <tr>
        <th><?php echo $prenom ?></th>
        <th><?php echo $mail ?></th>
        <th><?php echo $tel ?></th>
        <th><?php echo $telpro ?></th>
        <th><?php echo $fonction ?></th>
      </tr>
    </table>
    <?php
   }  
}
