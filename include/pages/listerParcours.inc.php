<?php
$db = new Mypdo();
$manager = new ParcoursManager($db);
$managerVille = new VilleManager($db);
?>
<h1>Liste des parcours proposés</h1>
<p>Actuellement <?php echo $manager->getNb(); ?> parcours sont enregistrées</p>
<table>
  <tr>
    <th>Numéro</th>
    <th>Nom ville</th>
    <th>Nom ville</th>
    <th>Nombre de Km</th>
  </tr>
  <?php
  $listeParcours = $manager->getList();

  foreach($listeParcours as $parcours){  ?>
    <tr>
      <td><?php echo $parcours->getPar_num(); ?></td>
      <td><?php echo $managerVille->getVilNomById($parcours->getVil_num1()); ?></td>
      <td><?php echo $managerVille->getVilNomById($parcours->getVil_num2()); ?></td>
      <td><?php echo $parcours->getPar_km(); ?></td>
    </tr>
  <?php
  }
  ?>
</table>
