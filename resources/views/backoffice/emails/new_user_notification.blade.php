<!DOCTYPE html>
<html>
<head>
    <title>Nouvel utilisateur inscrit</title>
</head>
<body>
    <h1>Un nouvel utilisateur a été inscrit avec succès !</h1>
    <p><strong>Pseudo:</strong> {{ $user->pseudo }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Contact:</strong> {{ $user->contact }}</p>
    <p><strong>Adresse:</strong> {{ $user->adresse }}</p>
    <p>Merci de vérifier les détails du nouvel utilisateur en accédant à l'application.</p>
    <p>Merci d'utiliser notre application !</p>
</body>
</html>
