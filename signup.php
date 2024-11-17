<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<p class='error'>Cet e-mail est déjà utilisé. Veuillez en choisir un autre.</p>";
    } else {
        // Insérer l'utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $password]);
        header('Location: signin.php');
        exit; // Assurez-vous de quitter le script après la redirection
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        /* Reset de la marge et du padding pour tous les éléments */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Corps de la page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Conteneur principal */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Formulaire d'inscription */
        .form-container {
            background-color: white;
            padding: 40px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Titre */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        /* Champs de saisie */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        /* Focus des champs de saisie */
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        /* Bouton de soumission */
        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Changement de couleur du bouton au survol */
        button[type="submit"]:hover {
            background-color: #005bb5;
        }

        /* Lien de connexion */
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        /* Lien d'inscription */
        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Message d'erreur */
        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        /* Responsivité pour les écrans plus petits */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Inscription</h2>
            <form action="signup.php" method="POST">
                <input type="email" name="email" placeholder="E-mail" required><br>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <button type="submit">S'inscrire</button>
            </form>
            <p>Vous avez déjà un compte ? <a href="signin.php">Connectez-vous ici</a>.</p>
        </div>
    </div>
</body>
</html>
