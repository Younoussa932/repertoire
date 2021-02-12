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
    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe'])){
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $sexe=$_POST['sexe'];
        $created_by= $user['id'];
        $created_at= date('Y-m-d H:i:s');
        $is_deleted= false;
        $insertpersonne = $bdd->prepare("INSERT INTO personne (nom, prenom, sexe, created_by, created_at, is_deleted) VALUES(?,?,?,?,?,?)");
        $status = $insertpersonne->execute(array($nom, $prenom, $sexe, $created_by, $created_at, $is_deleted));
        if($status == true){
            $_SESSION["message"] = "Enregistrement de <strong>".$nom." ".$prenom."</strong> réussi";
            $_SESSION["type_message"] = "success";
        }
        else{
            $_SESSION["message"] = "Une erreur s'est produite lors de l'enregistrement de ".$nom." ".$prenom;
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
    <form action="" method="POST">
        <div class="row m-5">
            <div class="col-md-4">
                <label for="nom">Nom:</label>
                <input type="text" id="" name="nom" placeholder="Votre Nom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="prenom">Prenom:</label>
                <input type="text" id="" name="prenom" placeholder="Votre Prénom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="sexe">Sexe:</label>
                <select name="sexe" id="sexe" class="form-control">
                    <option value="0"> Selectionner un èlèment</option>
                    <option value="1">Homme</option>
                    <option value="2">Femme</option>
                </select>
            </div>
        </div>
        <div class="row">
            <input class="btn btn-primary" type="submit" value="Enregister">
        </div>   
        <div class="row mt-2 mb-5"> 
            <input class="btn btn-info mb-5 " type="reset" value="Réinitialiser">
        </div>
    </form>
</div>

<?php
include("footer.php");
?>

<script src="jquery/jquery3.5.1.js"></script>  

</body>
</html>