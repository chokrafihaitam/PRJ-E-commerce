<?php
include "../public/template.php";

$idpanier = $_GET['id'];
$status = $_GET['status'];

// Update the status of the panier
$req = "UPDATE panier SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($link, $req);
mysqli_stmt_bind_param($stmt, "si", $status, $idpanier);
mysqli_stmt_execute($stmt);

if ($status != 'valider') {
    header("location:accueil.php");
    exit();
}

// Insert into commandes table
$numcmd = bin2hex(date('Y-m-d'));
$datecmd = date('Y-m-d');
$sql = "INSERT INTO `commandes`(`numcmd`, `datecmd`, `status`, `date_livraison`, `type_livraison`, `montant`) VALUES (?, ?, ?, NULL, NULL, NULL)";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "sss", $numcmd, $datecmd, $status);
mysqli_stmt_execute($stmt);

// Get the last inserted ID
$idcmd = mysqli_insert_id($link);

// Fetch products from panier_produit
$sql2 = "SELECT produit_id, quantites FROM panier_produit WHERE panier_id = ?";
$stmt = mysqli_prepare($link, $sql2);
mysqli_stmt_bind_param($stmt, "i", $idpanier);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Insert into ligne_cmd table
$sql = "";
while ($row = mysqli_fetch_assoc($result)) {
    $sql .= "INSERT INTO `ligne_cmd`(`id_cmd`, `id_produit`, `quantites`) VALUES ('$idcmd', '{$row["produit_id"]}', '{$row["quantites"]}');";
}

if (!empty($sql)) {
    mysqli_multi_query($link, $sql);
}

// Print the invoice link
echo "<div style=\"margin: 50px auto; width: max-content\"><a class=\"button\"  href='imprimer.php?id=".$idcmd."'>imprimer la facture</a></div>";