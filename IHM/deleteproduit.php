<?php
include "../public/template.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer l'image du serveur
    $result = mysqli_query($link, "SELECT image_url FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    unlink("produits/image/" . $product['image_url']);

    // Supprimer le produit de la base de données
    $sql = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        header("Location: produit.php");
    } else {
        echo "Erreur: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
