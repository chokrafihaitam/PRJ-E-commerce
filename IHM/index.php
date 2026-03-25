<?php
include "../public/template.php";
//var_dump($_SESSION);


if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header('location: login.php');
    exit;
}
?>


<body>
<main>
        <h2>Nos Produits</h2>
        <div class="product-list">
            <?php
                getProduits($link);
            ?>
        </div>
    </main>
    <div class="page-header">
        <!--<h1>Bonjour, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Bienvenue sur notre site.</h1>-->
    </div>
    <!-- <p><a href="deconnexion.php">Se déconnecter</a></p> -->
</body>
</html>
