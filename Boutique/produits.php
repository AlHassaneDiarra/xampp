<?php

session_start();


    require("produit.php");

    $produits = afficher();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<div class="header">
    <h1>Liste des produits:</h1> 
</div>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($produits as $produit): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <title><?= $produit->nom ?></title>
                        <img src="<?= $produit->image ?>" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text"><?= substr($produit->description, 0, 50); ?></p>
                            <form class="add-to-cart-form" id="add-to-cart-form-<?= $produit->id ?>">
                                <input type="hidden" name="id" value="<?= $produit->id ?>">
                                <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart-btn">Ajouter</button>
                            </form>
                            <small class="text-muted"><?= $produit->prix.'$'?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').click(function() {
        var form = $(this).closest('form');
        var productId = form.find('input[name="id"]').val();
        AjoutPanier(productId);
    });

    function AjoutPanier(productId) {
        $.ajax({
            type: 'GET',
            url: 'panier.php',
            data: {
                ajouter: true,
                id: productId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.cart-item-count').text(response.cartItemCount);
                    alert('Produit ajouté au panier !');
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function() {
                alert('Une erreur s\'est produite lors de l\'ajout au panier');
            }
        });
    }
});
</script>
</body>
</html>