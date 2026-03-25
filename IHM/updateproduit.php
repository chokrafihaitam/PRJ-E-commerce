<?php
include "../public/template.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($link, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    
    if (!$product) {
        die("Produit non trouvé !");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $promotions = $_POST['promotions'];

    // Gérer l'upload de l'image (optionnel)
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "produits/image/";
        $image_url = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_url;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image_url = $product['image_url'];
    }

    $sql = "UPDATE products SET name='$name', description='$description', price='$price', image_url='$image_url', promotions='$promotions' WHERE id=$id";
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
    <title>Modifier Produit</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="int">
                <h2>Modifier Produit</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="input-group form-group"><label>Nom:</label> <input type="text" name="name" value="<?= $product['name'] ?>" required></div>
                    <div class="input-group form-group"><label>Description:</label> <textarea name="description" required><?= $product['description'] ?></textarea></div>
                    <div class="input-group form-group"><label>Prix:</label> <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required></div>
                    <div class="input-group form-group"><label>Image:</label> <input type="file" name="image"></div>
                    <div class="input-group form-group"><img src="produits/image/<?= $product['image_url'] ?>" width="100"></div>
                    <div class="input-group form-group"><label>Promotions:</label> <input type="text" name="promotions" value="<?= $product['promotions'] ?>"></div>
                    <div class="button-group"><button type="submit">Modifier</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
