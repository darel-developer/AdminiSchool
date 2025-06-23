<!-- filepath: c:\xampp\htdocs\AdminiSchool\resources\views\emails\teacher-login.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos informations de connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            font-size: 24px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur AdminiSchool</h1>
        <p>Bonjour {{ isset($name) ? $name : ($first_name ?? '') . ' ' . ($last_name ?? '') }},</p>
        <p>Votre compte a été créé avec succès sur la plateforme AdminiSchool.</p>
        <p>Voici vos informations de connexion :</p>
        <ul>
            <li><strong>Email :</strong> {{ $email }}</li>
            <li><strong>Mot de passe :</strong> {{ $password }}</li>
        </ul>
        <p>Vous pouvez vous connecter en cliquant sur le lien suivant :</p>
        <p><a href="{{ $platformLink ?? $platform_link }}">{{ $platformLink ?? $platform_link }}</a></p>
        <p>Cordialement,</p>
        <p>L'équipe AdminiSchool</p>
        <div class="footer">
            <p>Si vous avez des questions, veuillez nous contacter à <a href="mailto:darel.sanang@fasciences-uy1.cm">darel.sanang@fasciences-uy1.cm</a>.</p>
        </div>
    </div>
</body>
</html>