<?php
include "../public/header.php";
include "../public/footer.php";
session_start();
require_once '../acces_bd/connexion.php';

$username = $password = '';
$username_err = $password_err = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(empty(trim($_POST['username']))){
        $username_err = 'Veuillez entrer votre nom d\'utilisateur.';
    } else{
        $username = trim($_POST['username']);
    }

    if(empty(trim($_POST['password']))){
        $password_err = 'Veuillez entrer votre mot de passe.';
    } else{
        $password = trim( $_POST['password']);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = 'SELECT id, username, password, role  FROM user WHERE username = ?';

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['role']=$role;
                            if ($_role=="admin");
                            header('location: index.php');
                        } else{
                            $password_err = 'Le mot de passe que vous avez entré n\'est pas valide.';
                        }
                    }
                } else{
                    $username_err = 'Aucun compte trouvé avec ce nom d\'utilisateur.';
                }
            } else{
                echo 'Oops! Quelque chose a mal tourné. Veuillez réessayer plus tard.';
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="int">
            <h2>Connexion</h2>
            <p>Veuillez remplir vos identifiants pour vous connecter.</p>
            <div class="login_form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                        <div class="error-group">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="input-group">
                            <label>Login</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        </div>
                        
                    </div>
                    <div class="form-group" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                        <div class="error-group">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="input-group">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="button-group">
                        <input type="submit" class="btn btn-primary" value="Se connecter">
                        <a href="inscrire.php">s'isncrire</a>
                    </div>
                <!--<p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous maintenant</a>.</p>-->
                </form>
            </div>
        </div>
    </div>
</body>
</html>
