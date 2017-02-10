<?php
$db = new Mypdo();
$manager = new VilleManager($db);
?>
<h1>Liste des villes</h1>
<p>Actuellement <?php echo $manager->getNb(); ?> villes sont enregistrées</p>
<table>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
  </tr>
  <?php
  $listeVille = $manager->getList();

  foreach($listeVille as $ville){  ?>
    <tr>
      <td><?php echo $ville->getVil_num(); ?></td>
      <td><?php echo $ville->getVil_nom(); ?></td>
    </tr>
  <?php
  }
  ?>
</table>
