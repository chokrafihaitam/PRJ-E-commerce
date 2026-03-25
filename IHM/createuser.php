<?php
include "../public/template.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $points = $_POST['points'];

    $password = "123";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'client';
    $sql ="INSERT INTO user (username, password, role) VALUES ('$email', '$hashed_password', '$role')";

    if (mysqli_query($link, $sql)) {
        $last_id = mysqli_insert_id($link);
        $sql = "INSERT INTO clients (user_id, nom, prenom, email, adresse, points) VALUES ($last_id, '$nom', '$prenom', '$email', '$adresse', '$points')";
    if (mysqli_query($link, $sql)) {
        header("Location: utilisateur.php");
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Client</title>
</head>
<body>
    <main>
    <h2>Ajouter un Client</h2>
        <div class="wrapper">
            <div class="int">
                <form method="post">
                    <div class="input-group form-group"><label>Nom:</label> <input type="text" name="nom" required></div>
                    <div class="input-group form-group"><label>Prénom:</label> <input type="text" name="prenom" required></div>
                    <div class="input-group form-group"><label>Email:</label> <input type="email" name="email" required></div>
                    <div class="input-group form-group"><label>Adresse:</label> <textarea name="adresse" required></textarea></div>
                    <div class="input-group form-group"><label>Points:</label> <input type="number" name="points" value="0"></div>
                    <button type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
