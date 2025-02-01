<?php 

function ajouter( $image, $nom, $prix, $desc)
{
    if(require("authentification/connexion.php"))
    {
        $req = $DB->prepare("INSERT INTO produits (image, nom, prix, description) VALUES ($image, $nom, $prix, $desc)");

        $req->execute(array($image, $nom, $desc, $prix));

        $req->closeCursor();
    }
}

function afficher()
{
    if(require("authentification/connexion.php"))
    {
        $req = $DB->prepare("SELECT * FROM produits ORDER BY id DESC");

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        return $data;

        $req->closeCursor();
    }
}

function supprimer($id)
{
    if(require("authentification/connexion.php"))
    {
        $req = $DB->prepare("DELETE * FROM produits WHERE id=?");

        $req->execute(array($id));
    }
}

?>