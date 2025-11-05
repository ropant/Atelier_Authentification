<?php
// Démarrer une session utilisateur qui sera en mesure de pouvoir gérer les Cookies
session_start();

// Vérifier si l'utilisateur est déjà en possession d'un cookie valide (cookie authToken)
// Si l'utilisateur possède déjà ce cookie, il sera redirigé automatiquement vers la page home.php
// Dans le cas contraire il devra s'identifier.
if (isset($_COOKIE['authToken']) && isset($_SESSION['authToken']) && $_COOKIE['authToken'] === $_SESSION['authToken']) {
    header('Location: page_admin.php');
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple du username et de son password.
    // Si ok alors on initialise le cookie sur le poste de l'utilisateur 
    if ($username === 'admin' && $password === 'secret') {

        // ✅ Génération d'un jeton unique au lieu d'une valeur statique (Exercice 2)
        $token = bin2hex(random_bytes(16));

        // ✅ Le Cookie est initialisé et valable pendant 1 minute (60 secondes) (Exercice 1)
        setcookie('authToken', $token, time() + 60, '/', '', false, true);

        // ✅ On mémorise la même valeur côté serveur pour pouvoir la vérifier ensuite
        $_SESSION['authToken'] = $token;

        header('Location: page_admin.php'); // L'utilisateur est dirigé vers la page admin.php
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
    <h3>La page <a href="page_admin.php">page_admin.php</a> est inaccéssible tant que vous ne vous serez pas connecté avec le login 'admin' et mot de passe 'secret'</h3>

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
