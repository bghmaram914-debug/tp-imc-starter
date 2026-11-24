<?php
require_once 'connexion.php';

// TODO 1 (Ex 7) : tous les patients de la table 'personnes'
$personnes = $pdo->query(
    "SELECT id, nom, prenom FROM personnes ORDER BY nom, prenom"
)->fetchAll();

// TODO 2 (Ex 7) : historique des mesures avec le nom du patient (INNER JOIN)
$mesures = $pdo->query(
    "SELECT m.id, p.nom, p.prenom, m.poids, m.taille, m.imc, m.categorie, m.date_mesure
     FROM mesures m
     INNER JOIN personnes p ON p.id = m.personne_id
     ORDER BY m.date_mesure DESC, m.id DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <h1>Calculateur d'IMC</h1>
    </header>

    <main>
        <section>
            <h2>Saisie</h2>
            <!-- TODO 3 : action et method ajoutés -->
            <form class="imc" action="ajouter.php" method="POST">
                <label>
                    Personne
                    <select name="personne_id" required>
                        <option value="">-- Choisir --</option>
                        <!-- TODO 4 : une <option> par patient, valeurs échappées -->
                        <?php foreach ($personnes as $p): ?>
                            <option value="<?= (int) $p['id'] ?>">
                                <?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Poids (kg)
                    <input id="imc-poids" name="poids" type="number" step="0.1" min="20" max="300" required />
                </label>

                <label>
                    Taille (m)
                    <input id="imc-taille" name="taille" type="number" step="0.01" min="0.5" max="2.5" required />
                </label>

                <div>
                    <button id="imc-calculer" type="button">Calculer</button>
                    <button type="submit">Enregistrer la mesure</button>
                </div>
            </form>
        </section>

        <section>
            <h2>Résultat</h2>
            <p>Votre IMC : <strong id="imc-valeur">-</strong></p>
            <p>Catégorie : <strong id="imc-categorie">-</strong></p>
        </section>

        <section>
            <h2>Historique des mesures</h2>
            <table>
                <thead>
                    <tr>
                        <th>Personne</th>
                        <th>Poids (kg)</th>
                        <th>Taille (m)</th>
                        <th>IMC</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- TODO 5 : une ligne <tr> par mesure -->
                    <?php foreach ($mesures as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['nom'] . ' ' . $m['prenom']) ?></td>
                            <td><?= htmlspecialchars($m['poids']) ?></td>
                            <td><?= htmlspecialchars($m['taille']) ?></td>
                            <td><?= htmlspecialchars($m['imc']) ?></td>
                            <td><?= htmlspecialchars($m['categorie']) ?></td>
                            <td><?= htmlspecialchars($m['date_mesure']) ?></td>
                            <td>
                                <a href="supprimer.php?id=<?= (int) $m['id'] ?>"
                                   onclick="return confirm('Supprimer cette mesure ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Centre de nutrition — ISTMT</p>
    </footer>
</body>
</html>