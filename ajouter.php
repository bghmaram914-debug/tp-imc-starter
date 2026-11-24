<?php
require_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO 1 (Ex 7) : récupération des données du formulaire
    $personne_id = $_POST['personne_id'] ?? '';
    $poids       = $_POST['poids'] ?? '';
    $taille      = $_POST['taille'] ?? '';

    // TODO 2 (Ex 8) : validation côté serveur (champs non vides + bornes)
    $personne_id = filter_var($personne_id, FILTER_VALIDATE_INT);
    $poids       = filter_var($poids, FILTER_VALIDATE_FLOAT);
    $taille      = filter_var($taille, FILTER_VALIDATE_FLOAT);

    $valide = $personne_id !== false && $personne_id > 0
           && $poids !== false && $poids >= 20 && $poids <= 300
           && $taille !== false && $taille >= 0.5 && $taille <= 2.5;

    if ($valide) {
        // TODO 3 (Ex 7) : calcul de l'IMC et détermination de la catégorie
        $imc = round($poids / ($taille * $taille), 1);

        if ($imc < 18.5) {
            $categorie = 'Sous-poids';
        } elseif ($imc < 25) {
            $categorie = 'Normal';
        } elseif ($imc < 30) {
            $categorie = 'Surpoids';
        } else {
            $categorie = 'Obésité';
        }

        // TODO 4 (Ex 7 & 8) : requête préparée (protection contre l'injection SQL)
        $stmt = $pdo->prepare(
            "INSERT INTO mesures (personne_id, poids, taille, imc, categorie)
             VALUES (:personne_id, :poids, :taille, :imc, :categorie)"
        );
        $stmt->execute([
            ':personne_id' => $personne_id,
            ':poids'       => $poids,
            ':taille'      => $taille,
            ':imc'         => $imc,
            ':categorie'   => $categorie,
        ]);
    }
}

// TODO 5 (Ex 7) : redirection vers index.php
header('Location: index.php');
exit;