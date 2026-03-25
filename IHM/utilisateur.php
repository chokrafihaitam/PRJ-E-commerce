<?php
include "../public/template.php";
include "../acces_bd/connexion.php";
$select="select * from clients ";
$req=mysqli_query($link,$select);
echo "<main><h2>Liste des Clients</h2>";
echo "<table class=\"panier_recup\"><thead>";

echo "<tr>";
echo"<th>nom</th>";
echo"<th>prenom</th>";
echo "<th>email</th>";
echo "<th>adresse</th>";
echo"<th>points</th>";
echo "<th>action</th>";

echo "</tr></thead>";
while($v=mysqli_fetch_assoc($req)){

    echo "<tbody><tr>";
    echo "<td>".$v['nom'].'</td>';
    echo "<td>".$v['prenom'].'</td>';
    echo "<td>".$v['email'].'</td>';
    echo "<td>".$v['adresse'].'</td>';
    echo "<td>".$v['points'].'</td>';
    echo "<td><a class=\"modify\" href='modifieruser.php?id=".$v['id']."'>modifier</a> <a class=\"delete\" href='supprimeuser.php?id=".$v['id']."' onclick=\"return confirm('Supprimer ce client ?')\">supprimer</a></td>";

echo "</tr></tbody>";
}
echo "</table>";
echo "<div class=\"button_panel\"><a class=\"button\" href='createuser.php'>Ajouter un Client</a></div></main>";
?> 

