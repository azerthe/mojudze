<nav class="span4">
    <h3>Menu</h3>   

    <!--Affichage du menu ainsi que des liens permettant la navigation sur les différentes pages du site-->
    <div class="navbar-inner">
        <ul class="nav nav-pills nav-stacked">
            <nav class="navbar navbar-light bg-faded">
                <h2 class="navbar-brand mb-0">LP ASR</h2>
            </nav>
            <li class="active">            
                <a href="index.php">Accueil</a>
            </li>
            
            <li>
                <a href="connexion.php">Connexion</a>
            </li>
            
            <li>
                <a href="Inscription.php">Inscription</a>
            </li>
            
            <li>
                <a href="moteur_recherche.php">Moteur de recherche</a>
            </li>

            <br>

            <?php
            //on vérifie si le cookie est égale à TRUE pour Afficher si l'utilisateur est connecté
            if (isset($_COOKIE['sid']) == TRUE)
            {
                ?>
                <div class="alert alert-success">
                    <i class="icon icon-check-circle icon-lg"></i>
                    <strong>Vous êtes connecté </strong> 
                </div>
                <?php
                ?>
                <li>
                    <a href="article.php">Rédiger un article</a>
                </li>
                
                <li>
                    <a href="deconnexion.php">déconnexion</a>
                </li>
    </div>
             <?php
             }
             //on vérifie si le cookie est égale à FALSE pour Afficher si l'utilisateur est déconnecté
             if (isset($_COOKIE['sid']) == FALSE)
             {
             ?>
                <div class="alert alert-warning">
                    <i class="icon icon-exclamation-circle icon-lg"></i>
                    <strong>Vous n'êtes pas connecté</strong>  </ul>
                </div>
             <?php
             }
             ?>
        </ul>
</nav>
</div>