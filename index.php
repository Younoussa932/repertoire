<?php 
    session_start();
    require 'connect.inc.php';
    if (isset($_POST['deconnexion'])){
        $_SESSION['user'] = null;
    }  
    if (isset($_SESSION['user'])){
        $user = $_SESSION['user'];
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
    <link rel="stylesheet" href="css/icon-font.css">
    <title>Page d'Acceuil</title>
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
        <?php 
            if (isset($_SESSION['message']) && $_SESSION['message'] != null){
                $type = 'info';
                if(isset($_SESSION["type_message"]) && $_SESSION["type_message"] != null){
                    $type = $_SESSION["type_message"];
                }
                echo '<div class="alert alert-'.$type.'">'.$_SESSION['message'].'</div>'; 
                $_SESSION['message'] = null; 
            }
        ?>
        <!-- <div class="alert alert-success">test</div>
        <div class="alert alert-info">test</div>
        <div class="alert alert-warning">test</div>
        <div class="alert alert-danger">test</div> -->


        <h1>Bienvenue sur notre site <?php if(isset($user)){echo $user['username'];}?></h1>
        <?php if($_SESSION['user'] != null): ?>
            <form action="" method="POST">
                <input type="submit" name="deconnexion" class="btn btn-danger" value="Se deconnecter">
                <a href="personne.php" class="btn btn-primary">Enregistrer un contact</a>
            </form>
            <?php
                $selectUserPersonne = $bdd->prepare("SELECT * FROM  personne WHERE created_by = :userId AND is_deleted = :deleted");
                $selectUserPersonne->execute(array("userId" => $user['id'], "deleted" => false));
                $personnes = $selectUserPersonne->fetchAll();
                // var_dump($personnes);
            ?>
                <table class="table table-bordered">
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Sexe</th>
                        <th>Actions</th>
                    </tr>
                    <?php $numero = 0;  ?>
                   
                    <?php foreach($personnes as $personne): ?>
                        <?php $numero += 1;  ?>
                        <tr>
                            <td>
                                <?= $numero;?>
                            </td>
                            <td>
                                <?= $personne['nom'];?>
                            </td>
                            <td>
                                <?= $personne['prenom'];?>
                            </td>
                            <td>
                                <?= $personne['sexe'] == 1 ? 'Homme' : 'Femme';?>
                            </td>
                            <td width ="16%">
                                <a href="supprimerPersonne.php?id=<?= $personne['id'];?>"" class="btn btn-danger btn-sm">Supprimer</a>
                                <a href="modifierPersonne.php?id=<?= $personne['id'];?>" class="btn btn-success btn-sm">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
        <?php else:  ?>
            <a href="connexion.php" class="btn btn-primary">Se connecter</a>
            <article  style="margin-top: 50px;">
                <div class="overlay">
                    <h2>Avec Super Repertoire</h2>
                    <h3>Organiser votre repertoire sur messure.</h3>
                    <a href="connexion.php" class="button">Démarrer</a>
                </div>
            </article>
    
            <section id="steps">
                <ul>
                    <li id="step-1">   
                        <h4>Ajouter</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum repudiandae expedita enim ullam laudantium praesentium voluptas, omnis, quaerat quis, quos minus exercitationem facere itaque odit nam quo a fugiat. Obcaecati.</p>
                    </li> 
                    <li id="step-2">
                        <h4>Modifier</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus vitae ipsum at dolore quibusdam, debitis repellendus nobis cumque architecto doloribus laudantium commodi, repudiandae inventore iure magnam.</p>
                    </li>
                    <li id="step-3">
                        <h4>Suprimer</h4>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quae excepturi quidem, magnam, debitis quo sapiente error quasi libero ducimus eligendi obcaecati rerum iusto blanditiis sequi fugit incidunt vero impedit. Incidunt!</p>
                    </li>    
                </ul>
            </section>
        <?php endif;  ?>

        <div class="clear"></div>
    </div>
    <?php
        include("footer.php")
    ?>
</body>
</html>