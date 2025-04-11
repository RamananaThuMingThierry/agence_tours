<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        /* Ajoutez vos styles personnalisés ici */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            text-align: center; /* Centre le texte et les images */
        }
        .logo {
            width: 200px; /* Ajustez la taille du logo */
            height: auto;
            margin-bottom: 20px; /* Espace sous le logo */
            border-radius: 100%;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #000000;
            background-color: #e9be00;
            text-decoration: none;
            border-radius: 2px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://images.wakelet.com/resize?id=bTPWLcE1XYXJU0QLPFeJR&h=705&w=768&q=85" alt="Logo" class="logo">
        <p>Bonjour !</p>
        <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
        <p><a href="{{ $resetUrl }}" class="button">Réinitialiser le mot de passe</a></p>
        <p>Ce lien de réinitialisation du mot de passe expirera dans 60 minutes.</p>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer ce message.</p>
        <div class="footer">
            <p>Cordialement,</p>
            <p>RAMANANA Thu Ming Thierry</p>
            <p>+261 32 75 637 70</p>
            <p>+261 38 29 216 85</p>
        </div>
    </div>
</body>
</html>
