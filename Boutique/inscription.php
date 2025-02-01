<?php 

    session_start();

    include_once('authentification/connexion.php');

    if(isset($_SESSION ['id'])){
      header('Location: connecter.php');
      exit;
    }
    
    if(!empty($_POST)){
      extract($_POST);

      $valid = (boolean) true;

      if(isset($_POST['inscription'])){
        $pseudo= trim($pseudo);
        $mail= trim($mail);
        $confmail= trim($confmail);
        $motdepasse= trim($motdepasse);
        $confmotdepasse= trim($confmotdepasse);

        if(empty($pseudo)){
          $valid = false;
          $err_pseudo = "Ce champ ne peut pas être vide";

        }else{
          $req = $DB->prepare("SELECT id 
              FROM users 
              WHERE pseudo = ?");

          $req->execute(array($pseudo));

          $req = $req->fetch();
        }

        if(empty($mail)){
          $valid = false;
          $err_mail = "Ce champ ne peut pas être vide";
        }elseif($mail <> $confmail){
          $valid = false;
          $err_mail = "Le mail est différent de la confirmation";
        }else{
          $req = $DB->prepare("SELECT id 
              FROM users 
              WHERE mail = ?");

          $req->execute(array($mail));

          $req = $req->fetch();

          if(isset($req['id'])){
            $valid = false;
            $err_mail = "Ce mail est déjà pris";
          }
        }

        if(empty($motdepasse)){
          $valid = false;
          $err_motdepasse = "Ce champ ne peut pas être vide";
        }elseif($motdepasse <> $confmotdepasse){
          $valid = false;
          $err_motdepasse = "Le mot de passe est différent de la confirmation";
        }

        if($valid){

          $crypt_motdepasse = password_hash($motdepasse, PASSWORD_ARGON2ID);

          echo $crypt_motdepasse;

          $date_creation = date('Y-m-d H:i:s');

          $req = $DB->prepare("INSERT INTO users(pseudo, mail, motdepasse, date_creation, date_connexion) VALUES (?,?,?,?,?)");
          $req->execute(array($pseudo, $mail, $crypt_motdepasse, $date_creation, $date_creation));
          
          header('Location: connecter.php');
          exit;
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

    <title>Inscription - Boutique</title>
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
              <h1 class="text-center mb-5">Inscription</h1>
              

      <form method="post">
        <div class="mb-3">
          <?php if(isset($err_pseudo)){ echo '<div>' . $err_pseudo . '</div>'; } ?>
            <label>Nom et Prénom</label>
            <input type="pseudo" class="form-control" name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; } ?>" placeholder="Nom et Prénom"/>
          </div>
          <div class="mb-3">
          <?php if(isset($err_mail)){ echo '<div>' . $err_mail . '</div>'; } ?>
            <label>Email</label>
            <input type="email" class="form-control" name="mail" value="<?php if(isset($mail)){ echo $mail; } ?>" placeholder="E-mail"/>
          </div>
          <div class="mb-3">
            <label>Confirmation Email</label>
            <input type="email" class="form-control" name="confmail" value="<?php if(isset($confmail)){ echo $confmail; } ?>" placeholder="Confirmation Mail"/>
          <div class="mb-3">
          <?php if(isset($err_motdepasse)){ echo '<div>' . $err_motdepasse . '</div>'; } ?>
            <label>Mot de passe</label>
            <input type="password" class="form-control" name="motdepasse" value="<?php if(isset($motdepasse)){ echo $motdepasse; } ?>" placeholder="Mot de passe"/>
          </div>
          <div class="mb-3">
            <label>Confirmation du mot de passe</label>
            <input type="password" class="form-control" name="confmotdepasse" value="<?php if(isset($confmotdepasse)){ echo $confmotdepasse; } ?>" placeholder="Mot de passe"/>
          </div>
          
          <div class="text-center mb-5">
            <div class="mb-3"> 
              <button type="submit" name="inscription" class="btn btn-success btn-lg btn-block">S'inscrire</button>
            </div>
            <p>Vous avez déjà un compte? <a href='connecter.php'> se connecter </a></p>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>