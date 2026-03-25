<?php
include("../acces_bd/connexion.php");
//var_dump($link);

function getProduits($link){
    $sql = "SELECT * from products";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($product = mysqli_fetch_assoc($result)) {
  //  echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["price"]. "<br>";
    echo '<div class="product-item">';
         echo '<img src="../IHM/produits/image/'.htmlspecialchars($product['image_url']) .'" alt=" ' .htmlspecialchars($product['name']).'" width="250px">';
        echo '<h3>'. htmlspecialchars($product['name']) .'</h3>';
        echo '<p>'. htmlspecialchars( $product['description']) .'</p>';
        echo '<p>Prix :' .number_format($product['price'], 2).' DH</p>';
        echo '<form action="ajouterpanier.php?id=' .$product['id'] .'" method = "post">';
        echo '<label for="quantity">Quantity:</label>';
        echo '<div class="">';
        echo '<input type="number" id="quantity" name="quantity" min="1" max="100" value="1" required>';
    echo '</div>';
    echo '<br>';
        echo'<button type="submit">ajouter au panier</button>';
        echo'</form>';
    echo '</div>';

  }
} else {
  echo "0 results";
}
    return 1;
  

}

function getid_panier($iduser,$link){
  $select="select id from panier where user_id=".$iduser." and status ='en cours'";
$res=mysqli_query($link,$select);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $idpanier=$row['id'];
    
  } else {

    $insert="INSERT INTO `panier`(`id`, `user_id`, `prix`, `status`) VALUES (NULL,'".$iduser."',0,'en cours' )";
    $res=mysqli_query($link,$insert);
    $idpanier = mysqli_insert_id($link);

  }

  return $idpanier;
}
function ajouter_article_panier($idpanier,$idarticle,$link, $qte){
  $select="SELECT `quantites` FROM `panier_produit` WHERE produit_id=".$idarticle." and panier_id=".$idpanier;
  $res=mysqli_query($link,$select);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $insert="UPDATE `panier_produit` SET `quantites`= quantites + ".$qte." WHERE produit_id=".$idarticle." and panier_id=".$idpanier;
    
  } else {

    $insert="INSERT INTO `panier_produit`(`panier_id`, `produit_id`,quantites) VALUES (".$idpanier.",".$idarticle.",".$qte.")";
    
}

$res=mysqli_query($link,$insert);
}

function getTotalCmd($link, $id){
  $select="SELECT sum(p.price * lc.quantites) total FROM products p , ligne_cmd lc WHERE p.id = lc.id_produit  and lc.id_cmd = ".$id;
  $res=mysqli_query($link,$select);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    if($row['total'])
    return $row['total']; 
  else return 0;   
  } else {

return 0;    
}
}

function getClientNomPrenom($link, $id){
  $select="SELECT `nom`, prenom FROM `clients` WHERE id =".$id;
  $res=mysqli_query($link,$select);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
return $row['nom']." ".   $row['prenom']; 
  } else {

return "Client nº ".$id;    
}
}

function getTotalSales($link){
  //$sqlSales = "SELECT SUM(montant) AS total_sales FROM commandes";
//$resultSales = mysqli_query($link, $sqlSales);
//$rowSales = mysqli_fetch_assoc($resultSales);
$select="SELECT sum(p.price * lc.quantites) total FROM products p , ligne_cmd lc, commandes c WHERE p.id = lc.id_produit  and lc.id_cmd = c.id and c.status = 'valider'";
  $res=mysqli_query($link,$select);
  $total = 0;
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $total +=  $row['total']; 
  } 
  return $total;
}

function getTotalOrders($link){
//   $sqlOrders = "SELECT COUNT(*) AS total_orders FROM commandes";
// $resultOrders = mysqli_query($link, $sqlOrders);
// $rowOrders = mysqli_fetch_assoc($resultOrders);
// $totalOrders = $rowOrders['total_orders'];
  $select="SELECT COUNT(*) AS total_orders FROM commandes WHERE status = 'valider'";
  $res=mysqli_query($link,$select);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
return $row['total_orders']; 
  } else {

return 0;    
}
}

function getMonthlySales($link){
  $result = [];
  $sqlMonthlySales = "SELECT DATE_FORMAT(c.datecmd, '%Y-%m') AS month, SUM(p.price * lc.quantites) AS monthly_sales 
                    FROM products p , ligne_cmd lc, commandes c  
                    WHERE p.id = lc.id_produit  and lc.id_cmd = c.id and c.status = 'valider'
                    GROUP BY DATE_FORMAT(c.datecmd, '%Y-%m') 
                    ORDER BY month";
$resultMonthlySales = mysqli_query($link, $sqlMonthlySales);
$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($resultMonthlySales)) {
    $labels[] = $row['month'];
    $data[] = $row['monthly_sales'];
}

$result['labels'] = $labels;
$result['data'] = $data;
  

return $result;    

}