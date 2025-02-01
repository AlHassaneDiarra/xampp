<?php
session_start();

include_once('authentification/connexion.php');


// Récupérer les informations de l'utilisateur depuis la base de données
$req = $DB->prepare("SELECT * FROM users WHERE id = ?");
$req->execute(array($_SESSION['id']));
$userInfo = $req->fetch();

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Profil - Boutique</title>
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
        <h1 class="text-center mb-5">Mon Profil</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">Nom et Prénom: <?php echo $userInfo['pseudo']; ?></li>
                <li class="list-group-item">E-mail: <?php echo $userInfo['mail']; ?></li>
                <li class="list-group-item">Date d'inscription: <?php echo date('d/m/Y H:i:s', strtotime($userInfo['date_creation'])); ?></li>
                <li class="list-group-item">Dernière connexion: <?php echo date('d/m/Y H:i:s', strtotime($userInfo['date_connexion'])); ?></li>
            </ul>
            </div>
        </div>
    </div>
</body>

</html>
