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

    // Sélection des type de contact
    $selectTypeContact = $bdd->prepare("SELECT * FROM type_contact");
    $selectTypeContact->execute();
    $types = $selectTypeContact->fetchAll();

    if (isset($_POST['sms'])){
        $contact           = $_POST['contact'];
        $type              = (int) $_POST['type'];
        $created_by        = (int) $user['id'];
        $created_at        = date('Y-m-d H:i:s');
        $is_deleted        = false;
        // $data = [$contact, $type, $created_by, $created_at, $is_deleted, $_GET['id']];
        // $requestAddContact = $bdd->prepare("INSERT INTO contact(`type_contact_id`, `personne_id`, `contact`, `created_at`, `created_by`, `is_deleted`) VALUE(?, ?, ?, ?, ?, ?);");
        // $status            = $requestAddContact->execute(array($type, $_GET['id'], $contact, $created_at, $created_by, $is_deleted));

        $requestAddContact = $bdd->prepare("INSERT INTO contact(type_contact_id, personne_id, contact, created_at, created_by, is_deleted) VALUE (:type_contact_id, :personne_id, :contact, :created_at, :created_by, :is_deleted);");
        $status            = $requestAddContact->execute(["type_contact_id" => $type,
                                                        "personne_id" => $_GET['id'], 
                                                        "contact" => $contact, 
                                                        "created_at" => $created_at, 
                                                        "created_by" => $created_by, 
                                                        "is_deleted" => $is_deleted]);
        if($status == true){
            $_SESSION["message"] = "Mise à jour de <strong>".$personne['nom']." ".$personne['prenom']."</strong> réussie";
            $_SESSION["type_message"] = "success";
        }
        else{
            $_SESSION["message"] = "Une erreur s'est produite lors de la mise à jour de <strong>".$personne['nom']." ".$personne['prenom']."</strong>";
        }
        // var_dump($bdd);
        // die();
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
    padding-bottom: 5px;">Mon <span class="orange">Super</span> Repertoire
</h1>

<?php
include("menu.php");
?>

<div class="container">
    <h1 style="text-align : center;">Ajout de contact pour <strong style="color: blue"><?= $personne['nom'], ' '.$personne['prenom'];?></strong> </h1>
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <label for="type">Type de contact:</label>
                <select name="type" id="type" class="form-control">
                    <option value="0"> Selectionner un èlèment</option>
                    <?php foreach($types as $type): ?>
                        <option value="<?= $type['id'] ?>"><?= $type['libelle'] ?></option> 
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" placeholder="Saisir le contact" required class="form-control">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <button class="btn btn-primary" name="sms">Enregistrer</button>
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