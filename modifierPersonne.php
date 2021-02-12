<?php
    session_start();
    
    require 'connect.inc.php';
    if (isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    else{
        $_SESSION['message'] = "Desole vous n'est pas connecté !";
        header("Location:index.php");
    }
    $selectPersonne = $bdd->prepare("SELECT * FROM personne WHERE id = :personneId AND created_by = :userId");
    $selectPersonne->execute(['personneId' => $_GET['id'], "userId" => $user['id']]);
    $personne = $selectPersonne->fetch();
    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe'])){
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $sexe=$_POST['sexe'];
        $updated_by= $user['id'];
        $updated_at= date('Y-m-d H:i:s');
        $miseAJour = $bdd->prepare("UPDATE personne SET nom = ?, prenom = ?, sexe = ?, updated_by = ?, updated_at = ? WHERE id = ?");
        // $insertpersonne = $bdd->prepare("UPDATE personne SET nom = :nom, prenom = , sexe, updated_by, updated_at) VALUES(?,?,?,?,?,?)");
        $status = $miseAJour->execute(array($nom, $prenom, $sexe, $updated_by, $updated_at, $_GET['id']));
        if($status == true){
            $_SESSION["message"] = "Mise à jour de <strong>".$nom." ".$prenom."</strong> réussie";
            $_SESSION["type_message"] = "success";
        }
        else{
            $_SESSION["message"] = "Une erreur s'est produite lors de la mise à jour de ".$nom." ".$prenom;
        }
        header('Location:index.php');
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Personne</title>
</head>
<body>
<h1 style="text-align: center;
    padding-top: 10px;
    color: blue;
    margin-left: 30%;
    width: 470px;
    border-bottom: 1px solid #000;
    padding-bottom: 5px;">Mon Super Repertoire<span class="orange">.</span>
</h1>

<?php
include("menu.php");
?>

<div class="container">
    <h1 style="text-align : center;">Modificatoin de <?= $personne['nom'], ' '.$personne['prenom'];?> </h1>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-4">
                <label for="nom">Nom:</label>
                <input type="text" id="" name="nom" value="<?= $personne['nom'];?>" placeholder="Votre Nom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="prenom">Prenom:</label>
                <input type="text" id="" name="prenom"  value="<?= $personne['prenom'];?>" placeholder="Votre Prénom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="sexe">Sexe:</label>
                <select name="sexe" id="sexe" class="form-control">
                    <option value="0"> Selectionner un èlèment</option>
                    <option value="1" <?php if ($personne['sexe'] == 1) :?> selected <?php endif;?>>Homme</option>
                    <option value="2" <?php if ($personne['sexe'] == 2):?> selected <?php endif;?>>Femme</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <input class="btn btn-primary" type="submit" value="Modifier">&nbsp;
            </div>
            <div class="col-1">
                <input class="btn btn-info mb-5 " type="reset" value="Réinitialiser">
            </div>
        </div>
    </form>
</div>

<?php
include("footer.php");
?>

<script src="jquery/jquery3.5.1.js"></script>  

</body>
</html>