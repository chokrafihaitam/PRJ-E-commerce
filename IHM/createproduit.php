<?php
include "../public/template.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $promotions = $_POST['promotions'];

    // Gérer l'upload de l'image
    $target_dir = "produits/image/";
    $image_url = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_url;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO products (name, description, price, image_url, promotions) 
            VALUES ('$name', '$description', '$price', '$image_url', '$promotions')";
    
    if (mysqli_query($link, $sql)) {
        header("Location: produit.php");
    } else {
        echo "Erreur: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit</title>
</head>
<body>
    <main>
        <h2>Ajouter un Produit</h2>
        <div class="wrapper">
            <div class="int">
                <form method="post" enctype="multipart/form-data">
                    <div class="input-group form-group"><label>Nom:</label> <input type="text" name="name" required></div>
                    <div class="input-group form-group"><label>Description:</label> <textarea name="description" required></textarea></div>
                    <div class="input-group form-group"><label>Prix:</label> <input type="number" step="0.01" name="price" required></div>
                    <div class="input-group form-group"><label>Image:</label> <input type="file" name="image" required></div>
                    <div class="input-group form-group"><label>Promotions:</label> <input type="text" name="promotions"></div>
                    <div class="input-group form-group"><button type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
