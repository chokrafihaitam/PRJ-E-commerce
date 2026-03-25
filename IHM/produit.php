<?php
include "../public/template.php";

// Récupérer tous les produits
$sql = "SELECT * FROM products";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Produits</title>
</head>
<body>
    <main>
    <h2>Liste des Produits</h2>
        <table class="panier_recup">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Promotions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= $product['price'] ?> DH</td>
                    <td><img src="produits/image/<?= htmlspecialchars($product['image_url']) ?>" width="100"></td>
                    <td><?= htmlspecialchars($product['promotions']) ?></td>
                    <td>
                        <a class="modify" href="updateproduit.php?id=<?= $product['id'] ?>">Modifier</a>
                        <a class="delete" href="deleteproduit.php?id=<?= $product['id'] ?>" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="button_panel">
            <a class="button" href="createproduit.php">Ajouter un Produit</a>
        </div>
    </main>
</body>
</html>

<?php
mysqli_close($link);
?>
