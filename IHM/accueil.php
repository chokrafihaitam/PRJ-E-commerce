<?php
include "../public/template.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Mon Site de commerce</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

    <main>
        <h2>Nos Produits</h2>
        <div class="product-list">
            <?php
            getProduits($link);
            ?>
        </div>
    </main>

</body>
</html>