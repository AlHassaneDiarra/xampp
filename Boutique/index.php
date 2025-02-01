<?php 
session_start();
    include_once('authentification/connexion.php');

?>
<!doctype html>
<html lang="fr">
  <head> 
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Acceuil - Boutique</title>

    <style>
      .bienvenue {
    text-align: center;
}

      .header-image {
    text-align: center;
    margin-top: 0;
    padding: 20px 0;
}

    .header-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }



      .description {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.images-row {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

    .images-row img {
        width: 250px;
        height: auto;
        margin: 0 10px;
    }
.cta {
    text-align: center;
    margin-top: 40px;
}

    .cta a {
        display: inline-block;
        padding: 10px 20px;
        background-color: green;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 18px;
        transition: background-color 0.3s;
    }

        .cta a:hover {
            background-color: #444;
        }
    </style>

  </head>
  <body>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php">Acceuil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="produits.php">Produits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">À Propos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if (!isset($_SESSION['id'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Connexion
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="connecter.php">Se connecter</a></li>
                        <li><a class="dropdown-item" href="inscription.php">S'inscrire</a></li>
                    </ul>
                </li>
            <?php } else { ?>
                <a class="nav-link" href="panier.php">Panier <?php if (isset($_SESSION['panier'])) { echo '(' . count($_SESSION['panier']) . ')'; } ?></a>
                <a class="nav-link dropdown" href="deconnexion.php">Déconnexion</a>
                <a class="nav-link" href="profil.php"><strong><?php echo $_SESSION['pseudo']; ?></strong></a>
            <?php } ?>
        </ul>
    </div>
</div>
</nav>



<div class="container">
<h1 class="bienvenue">Bienvenue dans ma Boutique de Vêtements</h1> 
<br />
<p class="description">Découvrez notre collection de vêtements tendance pour hommes, conçus pour allier style et confort. Que vous recherchiez des tenues décontractées, des costumes élégants ou des vêtements de sport, nous avons ce qu'il vous faut.</p>
<div class="header-image">
    <img src='Images/Acceuil.png' alt="Boutique de Vêtements pour Hommes">
</div>
    <p class="description">Parcourez notre sélection de chemises, pantalons, vestes, costumes, jeans, accessoires et bien plus encore, pour compléter votre garde-robe avec des pièces de qualité supérieure.</p>
    <div class="images-row">
        <img src='Images/Polo.png' alt="Polo">
        <img src='Images/Pull.png' alt="Pull">
        <img src='Images/t-shirt.png' alt="T-shirt">
    </div>
    <p class="description">Profitez d'une expérience de shopping en ligne facile et sécurisée, avec une livraison rapide et un service clientèle exceptionnel. Restez à la pointe de la mode avec notre boutique de vêtements pour hommes.</p>
</div>
<div class="cta">
    <a href="produits.php">Découvrir nos produits</a>
</div>

<footer>
                  <p>    </p>
</footer>
  </body>
</html>