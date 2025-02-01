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

    <title>À Propos - Boutique de Vêtements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
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
    <h1>À Propos de Notre Boutique</h1>
    <p>Nous sommes une boutique de vêtements en ligne passionnée par la mode et les dernières tendances. Notre objectif est de vous offrir une expérience de magasinage exceptionnelle et de vous aider à exprimer votre style unique à travers nos collections soigneusement sélectionnées.</p>
    <p>Notre équipe est composée de professionnels de la mode dévoués qui recherchent constamment les meilleurs produits pour vous. Que vous cherchiez des vêtements décontractés, des tenues élégantes pour le travail ou des pièces sensationnelles pour une occasion spéciale, nous avons tout ce dont vous avez besoin pour compléter votre garde-robe.</p>
    <p>La satisfaction de nos clients est notre priorité absolue. Nous nous engageons à fournir un service client exceptionnel et à garantir que chaque achat que vous faites avec nous soit une expérience positive. Nous sommes reconnaissants pour votre soutien continu et nous attendons avec impatience de vous servir encore et encore.</p>
    <p>Merci d'avoir choisi notre boutique de vêtements. N'hésitez pas à nous contacter si vous avez des questions ou des commentaires. Nous sommes là pour vous aider!</p>
</div>
  </body>
</html>