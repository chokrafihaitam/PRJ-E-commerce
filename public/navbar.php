<?php
if(isset($_SESSION ['role'])){
    ?>






<div class="navbar">
    <div class="burger-menu" onclick="toggleMenu()">&#9776;</div>
      <div class="navbar-links" id="navbar-links">
        <a href="index.php">Accueil</a>
        <a href="panier.php">Panier</a>
  
    <?php
    if($_SESSION['role']=='vendeur'){
  ?>
    
    <a href="produit.php">Gerer les produits</a>
    <!--<a href="consulter.php">Consulter la liste des clients et leurs commandes</a>-->

    <?php
    }
    elseif($_SESSION['role']=='admin'){    
      ?>
    <a href="produit.php">Gerer les produits</a>
    <a href="utilisateur.php">Gerer les comptes utilisateurs</a>
    <a href="statistique.php">Generer des statistiques et rapports</a>
    <a href="supervisione.php">Superviser les operations</a>
    <?php
    }
    ?>

    </div>
  </div>
  <script>
  function toggleMenu() {
    const menu = document.getElementById('navbar-links');
    menu.classList.toggle('show');
  }
</script>

<?php
}
?>