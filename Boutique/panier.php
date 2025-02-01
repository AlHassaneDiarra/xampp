<?php
session_start();
require("produit.php");

// Vérifier si l'utilisateur est connecté, sinon retourner une erreur
if (!isset($_SESSION['id'])) {
    echo json_encode(array('success' => false, 'message' => 'Utilisateur non connecté'));
    exit;
}

// Vérifier si la session panier existe, sinon initialiser un tableau vide
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Ajouter un produit au panier si l'ID du produit est passé en GET
if (isset($_GET['ajouter']) && isset($_GET['id'])) {
    $produit_id = $_GET['id'];
    $produit_info = getProduitInfo($produit_id); // Obtenir les informations du produit
    if ($produit_info) {
        $index = array_search($produit_id, array_column($_SESSION['panier'], 'id'));
        if ($index !== false) {
            $_SESSION['panier'][$index]['quantite']++;
        } else {
            $_SESSION['panier'][] = array(
                'id' => $produit_id,
                'nom' => $produit_info->nom, // Utiliser le nom du produit récupéré depuis la base de données
                'description' => $produit_info->description,
                'prix' => $produit_info->prix,
                'quantite' => 1
            );
        }
        echo json_encode(array('success' => true, 'cartItemCount' => count($_SESSION['panier'])));
        exit;
    } else {
        echo json_encode(array('success' => false, 'message' => 'Produit non trouvé'));
        exit;
    }
}

// Supprimer un produit du panier si l'ID du produit est passé en GET
if (isset($_GET['supprimer']) && isset($_GET['id'])) {
    $produit_id = $_GET['id'];
    $index = array_search($produit_id, array_column($_SESSION['panier'], 'id'));
    if ($index !== false) {
        unset($_SESSION['panier'][$index]);
        echo json_encode(array('success' => true, 'cartItemCount' => count($_SESSION['panier'])));
        exit;
    } else {
        echo json_encode(array('success' => false, 'message' => 'Produit non trouvé dans le panier'));
        exit;
    }
}

// Fonction pour récupérer les informations d'un produit à partir de son ID
function getProduitInfo($id) {
    // À titre d'exemple, vous devrez adapter cette fonction à votre propre base de données
    // C'est ici où vous obtiendrez les informations détaillées du produit à partir de l'ID
    // Dans cet exemple, je vais simplement renvoyer des données factices pour la démonstration
    $produits = afficher();
    foreach ($produits as $produit) {
        if ($produit->id == $id) {
            return $produit;
        }
    }
    return null;
}

// Fonction pour calculer le prix total de tous les produits dans le panier
function calculTotal() {
    $total = 0;
    foreach ($_SESSION['panier'] as $produit) {
        $total += $produit['prix'] * $produit['quantite'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Boutique</title>
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

<div class="container mt-5">
    <h1>Votre Panier</h1>
    <?php if (empty($_SESSION['panier'])) { ?>
        <p>Votre panier est vide.</p>
    <?php } else { ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix unitaire</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Total</th> <!-- Nouvelle colonne pour le total -->
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['panier'] as $key => $produit) { ?>
                    <tr>
                        <th scope="row"><?php echo $key + 1; ?></th>
                        <td><?php echo $produit['nom']; ?></td>
                        <td><?php echo $produit['description']; ?></td>
                        <td><?php echo $produit['prix'].'$'; ?></td>
                        <td><?php echo $produit['quantite']; ?></td>
                        <td><?php echo $produit['prix'] * $produit['quantite'].'$'; ?></td> 
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-from-cart-btn" data-id="<?php echo $produit['id']; ?>">Supprimer</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Prix total</th>
                    <td colspan="2"><?php echo calculTotal().'$'; ?></td>
                </tr>
            </tfoot>
        </table>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.remove-from-cart-btn').click(function() {
        var productId = $(this).data('id');
        SupprimerPanier(productId);
    });

    function SupprimerPanier(productId) {
        $.ajax({
            type: 'GET',
            url: 'panier.php',
            data: {
                supprimer: true,
                id: productId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.cart-item-count').text(response.cartItemCount);
                    location.reload();
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function() {
                alert('Une erreur s\'est produite lors de la suppression du produit du panier');
            }
        });
    }
});
</script>

</body>
</html>
