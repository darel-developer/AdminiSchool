<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            margin: 20px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature img {
            max-width: 150px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo_ecole.png') }}" alt="Logo de l'école">
        <h1>École XYZ</h1>
        <p><em>"Apprendre aujourd'hui pour réussir demain"</em></p>
        <p>Adresse: 123 Rue de l'Éducation, Ville, Pays</p>
    </div>
    <div class="content">
        <h2>Facture</h2>
        <p><strong>Nom:</strong> {{ $paiement->nom }}</p>
        <p><strong>Prénom:</strong> {{ $paiement->prenom }}</p>
        <p><strong>Type de Paiement:</strong> {{ $paiement->typepaiement }}</p>
        <p><strong>Montant:</strong> {{ $paiement->montant }}</p>
        <p><strong>Numéro de Facture:</strong> {{ $paiement->num_facture }}</p>
        <p><strong>État:</strong> {{ $paiement->etat }}</p>
    </div>
    <div class="signature">
        <p>Signature numérique:</p>
        <img src="{{ asset('images/signature.png') }}" alt="Signature">
    </div>
    <div class="footer">
        <p>Merci pour votre paiement</p>
    </div>
</body>
</html>