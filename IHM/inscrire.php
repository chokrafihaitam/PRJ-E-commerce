<?php
include "../public/template.php";
include "../acces_bd/connexion.php";
// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données soumises
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = "client";//$_POST['role'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "<h3 style='color: red;'>Les mots de passe ne correspondent pas.</h3>";
        exit;
    }

    // Valider le mot de passe (au moins 8 caractères, avec des lettres et des chiffres)
    if (strlen($password) <4 ) {
        echo "<h3 style='color: red;'>Le mot de passe doit contenir au moins 8 caractères, avec des lettres et des chiffres.</h3>";
        exit;
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h3 style='color: red;'>L'email est invalide.</h3>";
        exit;
    }

    // Pour des raisons de sécurité, vous devez hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Vous pouvez maintenant insérer ces données dans une base de données
    // Exemple de connexion à une base de données MySQL (à adapter selon votre configuration)
    


    // Préparer et exécuter l'insertion des données
    $sql ="INSERT INTO user (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    if (mysqli_query($link, $sql)) {
        $last_id = mysqli_insert_id($link);
        if($role=="client"){
$sql="INSERT INTO `clients`( `user_id`, `nom`, `prenom`, `email` ) VALUES ($last_id,'$last_name','$first_name','$email')";
        }
        elseif ($role=="vendeur")
        $sql="INSERT INTO `vendeurs`( `user_id`, `nom`, `prenom`, `email` ) VALUES ($last_id,'$last_name','$first_name','$email')";
        if (mysqli_query($link, $sql)) {

            header('location:../index.php');
        }

      } else {
        echo "<h3 style='color: red;'>Erreur lors de l'inscription.</h3>";
    
      }








}
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
</head>
<body>
<div class="wrapper">
    <div class="int">
        <h2>Formulaire d'inscription</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="input-group form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="input-group form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <!-- /<label for="role">Rôle :</label>
            <select id="role" name="role" required>
                <option value="client">Client</option>
                <option value="vendeur">Vendeur</option>
            </select><br><br> -->

            <div class="input-group form-group">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div class="input-group form-group">
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="input-group form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="button-group">
                <input type="submit" class="btn btn-primary" value="S'isncrire">
                <a href="login.php">Se connecter</a>
            </div>
        </form>
    </div>
</div>
    

</body>
</html>
