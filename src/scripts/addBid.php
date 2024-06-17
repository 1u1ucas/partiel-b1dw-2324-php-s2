<?php


$id = $_POST['id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$request = $connectDatabase->prepare("INSERT INTO bid (post_id, montant) VALUES (:post_id, :montant)");

$request->bindParam(':post_id', $id);

$request->bindParam(':montant', $_POST['montant']);

$request->execute();

header('Location: ../ticket.php?id=' . $id);