<?php
require_once 'connexion.php';

// TODO 1 (Ex 7) : vérifier que $_GET['id'] existe et est un entier valide
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int) $_GET['id'];

    if ($id > 0) {
        // TODO 2 (Ex 7 & 8) : requête préparée DELETE
        $stmt = $pdo->prepare("DELETE FROM mesures WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

// TODO 3 (Ex 7) : redirection vers index.php
header('Location: index.php');
exit;