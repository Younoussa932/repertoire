<?php
    $bdd=new PDO('mysql:host=localhost;dbname=test_repertoire','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>