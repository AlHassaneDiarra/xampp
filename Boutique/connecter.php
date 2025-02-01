<?php 

session_start();

include_once('authentification/connexion.php');

if(isset($_SESSION['id'])){
  header('Location: index.php');
  exit;
}

if(!empty($_POST)){
  extract($_POST);

  $valid = (boolean) true;

  if(isset($_POST['connecter'])){

    $mail= trim($mail);
    $motdepasse= trim($motdepasse);

    if(empty($mail)){
      $valid = false;
      $err_mail = "Ce champ ne peut pas être vide";
    }

    if(empty($motdepasse)){
      $valid = false;
      $err_motdepasse = "Ce champ ne peut pas être vide";
    }

    if($valid){
      $req = $DB->prepare("SELECT motdepasse 
          FROM users 
          WHERE mail = ?");

      $req->execute(array($mail));

      $req_connecter = $req->fetch();

      if(isset($req_connecter['motdepasse'])){
        // Récupérer le mot de passe crypté depuis la base de données
        $crypt_motdepasse = $req_connecter['motdepasse'];
        // Comparer le mot de passe fourni par l'utilisateur avec le mot de passe crypté
        if(!password_verify($motdepasse, $crypt_motdepasse)){
          $valid = false;
          $err_motdepasse = "Mot de passe incorrect. Veuillez réessayer.";
        }
        
      }else{
        $valid = false;
        $err_mail = "Ce mail est incorrect";
      }

      if($valid){

        $req = $DB->prepare("SELECT * 
            FROM users 
            WHERE mail = ?");

        $req->execute(array($mail));

        $req_connecter = $req->fetch();

        if(isset($req_connecter['id'])){
          $crypt_motdepasse = password_hash($motdepasse, PASSWORD_ARGON2I);
  
          echo $crypt_motdepasse;
          $date_connexion = date('Y-m-d H:i:s');

          $req = $DB->prepare("UPDATE users SET date_connexion = ? WHERE id = ?");
          $req->execute(array($date_connexion, $req_connecter['id']));

          $_SESSION['id'] = $req_connecter['id'];
          $_SESSION['pseudo'] = $req_connecter['pseudo'];
          $_SESSION['mail'] = $req_connecter['mail'];

          
          header('Location: index.php');
          exit;
        }else{
          $valid = false;
          $err_mail = "Ce mail est incorrect";
        }
      }
    }
  }
}

?>

<!doctype html>
  <html lang="fr">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <title>Connecter - Boutique</title>
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
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-6">
                  <h1 class="text-center mb-5">Connexion</h1> 

            <form method="post">
              <div class="mb-3">
                <?php if(isset($err_mail)){ echo '<div>' . $err_mail . '</div>'; } ?>
                <label>E-mail</label>
                <input type="email" class="form-control" name="mail" value="<?php if(isset($mail)){ echo $mail; } ?>" placeholder="E-mail"/>
              </div>
              <div class="mb-3">
                <?php if(isset($err_motdepasse)){ echo '<div>' . $err_motdepasse . '</div>'; } ?>
                <label>Mot de passe</label>
                <input type="password" class="form-control" name="motdepasse" value="<?php if(isset($motdepasse)){ echo $motdepasse; } ?>" placeholder="Mot de passe"/>
              </div>
              <div class="text-center mb-5">
                <div class="mb-3"> 
                <button type="submit" name="connecter" class="btn btn-success btn-lg btn-block">Se connecter</button>
                </div>
                <p>Vous n'avez pas de compte? <a href='inscription.php'> s'inscrire</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </body>
  </html>
