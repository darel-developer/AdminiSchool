<!-- filepath: c:\xampp\htdocs\AdminiSchool\resources\views\emails\teacher-login.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos accès à la plateforme AdminiSchool</title>
</head>
<body>
    <p>Bonjour {{ $first_name }} {{ $last_name }},</p>
    <p>Votre compte enseignant a été créé avec succès sur la plateforme AdminiSchool.</p>
    <p><strong>Voici vos informations de connexion :</strong></p>
    <ul>
        <li>Email : <strong>{{ $email }}</strong></li>
        <li>Mot de passe : <strong>{{ $password }}</strong></li>
    </ul>
    <p>Vous pouvez vous connecter en cliquant sur le lien suivant :</p>
    <p>
        <a href="{{ $platform_link }}" target="_blank">{{ $platform_link }}</a>
    </p>
    <p>Cordialement,<br>L'équipe AdminiSchool</p>
</body>
</html>