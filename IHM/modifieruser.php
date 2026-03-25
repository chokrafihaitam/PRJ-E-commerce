<?php
include "../public/template.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($link, "SELECT * FROM clients WHERE id = $id");
    $client = mysqli_fetch_assoc($result);
    
    if (!$client) {
        die("Client non trouvé !");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $points = $_POST['points'];

    $sql = "UPDATE clients SET nom='$nom', prenom='$prenom', email='$email', adresse='$adresse', points='$points' WHERE id=$id";
    if (mysqli_query($link, $sql)) {
        header("Location: utilisateur.php");
    } else {
        echo "Erreur: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Client</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="int">
                <h2>Modifier Client</h2>
                <form method="post">
                     <div class="input-group form-group"><label>Nom:</label> <input type="text" name="nom" value="<?= $client['nom'] ?>" required></div>
                     <div class="input-group form-group"><label>Prénom:</label> <input type="text" name="prenom" value="<?= $client['prenom'] ?>" required></div>
                     <div class="input-group form-group"><label>Email:</label> <input type="email" name="email" value="<?= $client['email'] ?>" required></div>
                     <div class="input-group form-group"><label>Adresse:</label> <textarea name="adresse" required><?= $client['adresse'] ?></textarea></div>
                     <div class="input-group form-group"><label>Points:</label> <input type="number" name="points" value="<?= $client['points'] ?>"></div>
                     <div class="button-group"><button type="submit">Modifier</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
