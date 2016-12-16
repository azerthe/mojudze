 <nav class="span4">
     
     
     
            <h3>Menu</h3>     
            <ul class="nav nav-pills nav-stacked">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="Inscription.php">Inscription</a></li>
                <li><a href="moteur_recherche.php">Moteur de recherche</a></li>
                 <br>
                 <?php
                  if(isset($_COOKIE['sid'])==TRUE)
                  {  
                       
                      echo 'Vous êtes connecté'; 
                      ?>
                      <li><a href="article.php">Rédiger un article</a></li>
                      <li><a href="deconnexion.php">déconnexion</a></li>
                      <?php
                  }
                  if(isset($_COOKIE['sid'])==FALSE)
                  {
                      echo 'Vous êtes déconnecté';   
                  }
                  ?>
             </ul>
            
          </nav>
</div>