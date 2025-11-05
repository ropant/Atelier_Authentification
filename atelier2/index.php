<?php
// Démarrer une session (nécessaire pour mémoriser le jeton côté serveur)
session_start();

// Si un jeton existe dans le cookie ET dans la session
// alors l'utilisateur est déjà connecté → on le redirige
if (isset($_COOKIE['authToken']) && isset($_SESSION['authToken']) && $_COOKIE['authToken'] === $_SESSION['authToken']) {
    header('Location: page_admin.php');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple du login et mdp
    if ($username === 'admin' && $password === 'secret') {

        // ✅ Exercice 2 : Générer un jeton unique
        $token = bin2hex(random_bytes(16));

        // ✅ Exercice 1 : Cookie valable 1 minute (60 secondes)
        setcookie('authToken', $token, time() + 60, '/', '', false, true);

        // On garde le même jeton côté serveur (session)
        $_SESSION['authToken'] = $token;

        // Redirection vers page protégée
        header('Location: page_admin.php');
        exit();

    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Cookie</h1>
    <h3>La page <a href="page_admin.php">page_admin.php</a> est inaccéssible tant que vous ne vous serez pas connecté.</h3>

    <?php if (isset($error)) : ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Se connecter</button>
    </form>

    <br>
    <a href="../index.html">Retour à l'accueil</a>  
</body>
</html>
