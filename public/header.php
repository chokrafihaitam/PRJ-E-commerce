<header>
        <div class="logo">
                <a href="../"><img src="http://localhost/e-commerce/public/ensi.png" width="100px"></a>
        </div>
        <div class="connextion_div">
                <?php
                //session_start();
                
                if(!isset($_SESSION['username']) || empty($_SESSION['username'])){ ?>
                <a href="../IHM/login.php">Se connecter</a>
                <?php }else 
                {?>

                <a href="../IHM/deconnexion.php"> Se deconnecter</a>
                <?php } ?> 
        </div>
        
        <!-- Navigation -->
</header>