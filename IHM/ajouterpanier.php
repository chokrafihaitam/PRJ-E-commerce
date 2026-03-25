<?php
include("../acces_bd/connexion.php");
include("../action/commande.php");
session_start();
if(!$_SESSION) {
    echo "erreur : pour ajouter l'article au panier merci de <a href='login.php'>se connecter</a> ";
    exit();
}
$iduser=$_SESSION['id'];
if(isset($_GET['id'])){
    $qte = $_POST['quantity'];
$idproduit=$_GET['id'];
$idpanier=getid_panier($iduser,$link);
ajouter_article_panier($idpanier,$idproduit,$link, $qte );
header("location:accueil.php");

}

else {

    echo "erreur : merci d'ajouter un produit ";

}