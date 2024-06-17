<?php



$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$request = $connectDatabase->prepare("UPDATE post SET categorie = :categorie, groupe = :groupe, equipe1 = :equipe1, equipe2 = :equipe2, description = :description, prix = :prix, date_heure = :date_heure, lieu = :lieu WHERE id = :id");

$request->bindParam(':categorie', $_POST['categorie']);
$request->bindParam(':groupe', $_POST['groupe']);
$request->bindParam(':equipe1', $_POST['equipe1']);
$request->bindParam(':equipe2', $_POST['equipe2']);
$request->bindParam(':description', $_POST['description']);
$request->bindParam(':prix', $_POST['price']);
$request->bindParam(':date_heure', $_POST['date_heure']);
$request->bindParam(':lieu', $_POST['lieu']);
$request->bindParam(':id', $_POST['id']);

$request->execute();

header('Location: ../index.php');