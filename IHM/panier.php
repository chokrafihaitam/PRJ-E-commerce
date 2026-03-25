<?php
include "../public/template.php";
$iduser=$_SESSION['id'];
$idpanier=getid_panier($iduser,$link);
$select="SELECT pr.id produit_id, pr.name,pr.description,pr.price,pr.image_url,pp.quantites FROM products pr , panier pn , panier_produit pp 
where pr.id=pp.produit_id 
and pn.id=pp.panier_id 
and pn.user_id=".$iduser." 
and pn.status='en cours'
and pn.id=".$idpanier;
$res=mysqli_query($link,$select);
echo "<main><h2>Votre panier</h2>";
echo "<table class=\"panier_recup\">";
echo "<thead>
        <tr>
            <th>Produit</th>
            <th>Description</th>
            <th>Image</th>
            <th>Prix Unitaire</th>
            <th>Multiplication</th>
            <th>Quantité</th>
            <th></th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>";

/* echo "<tr>";
echo"<td>produit</td>";
echo"<td>description</td>";
echo "<td>prix</td>";
echo "<td>prix</td>";
echo "<td>quantites</td>";
echo "</tr>"; */
if (mysqli_num_rows($res) > 0) {
while($v=mysqli_fetch_assoc($res)){

    echo "<tr>";
    echo "<td>".$v['name'].'</td>';
    echo "<td>".$v['description'].'</td>';


    echo '<td><img src="../IHM/produits/image/'.htmlspecialchars($v['image_url']) .'" alt=" ' .htmlspecialchars($v['name']).'"></td>';

    echo "<td>".$v['price'].'</td>';
    echo "<td>x</td>";
    echo "<td>".$v['quantites'].'</td>';
    echo "<td>=</td>";
    echo "<td>".$v['price']*$v['quantites'].' DH</td>';

    echo "<td> <a class=\"delete\" href='supprimeproduitpanier.php?id=".$v['produit_id']."'>supprimer</a></td>";

echo "</tr>";
}
echo "</table>";
echo "<div class=\"button_panel\"><a class=\"button\" href='validerpanier.php?id=".$idpanier."&status=valider'>valider</a>&nbsp;";
echo "<a class=\"button\" href='validerpanier.php?id=".$idpanier."&status=annuler'>annuler panier</a></div></main>";
} else {
    header("location: accueil.php");
  }
?> 

