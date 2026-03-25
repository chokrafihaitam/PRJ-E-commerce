<?php
include "../public/template.php";

// Récupérer tous les produits
$sql = "SELECT * FROM commandes";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Superviser l’ensemble des opérations du magasin</title>
</head>
<body>
    <main>
        <h2>Superviser l’ensemble des opérations du magasin</h2>
        <h4>Liste des commandes</h4>
        <table class="panier_recup">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nº <Command></Command></th>
                    <th>Date</th>
                    <th>montant</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cmd = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $cmd['id'] ?></td>
                    <td><?= htmlspecialchars($cmd['numcmd']) ?></td>
                    <td><?= htmlspecialchars(date("d/m/Y", strtotime($cmd['datecmd']))) ?></td>
                    <td><?= getTotalCmd($link, $cmd['id']) ?> DH</td>
                    <td><?= htmlspecialchars(getClientNomPrenom($link, $cmd['idClient'])) ?></td>
                    <td><?= htmlspecialchars($cmd['status']) ?></td>
                    <td>
                        <?php if($cmd['status'] == 'valider'){ ?>
                    <a href='imprimer.php?id=<?= $cmd['id'] ?>'>imprimer la facture</a>
                    <?php } ?>
                </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
mysqli_close($link);
?>
