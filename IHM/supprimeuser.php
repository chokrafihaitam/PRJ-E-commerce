<?php
include "../public/template.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE id = (select user_id from clients where id = $id)";
    if (mysqli_query($link, $sql)) {
        $sql = "DELETE FROM clients WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        header("Location: utilisateur.php");
    } else {
        echo "Erreur: " . mysqli_error($link);
    }
    } else {
        echo "Erreur: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
