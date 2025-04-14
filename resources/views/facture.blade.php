<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\facture.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            margin: 20px;
        }
        .content h2 {
            text-align: center;
        }
        .content p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo2.png') }}" alt="Logo de l'école">
        <h1>École XYZ</h1>
        <p><em>"Apprendre aujourd'hui pour réussir demain"</em></p>
        <p>Adresse: 123 Rue de l'Éducation, Ville, Pays</p>
    </div>
    <div class="content">
        <h2>Facture</h2>
        <p><strong>Nom :</strong> {{ $paiement->nom }}</p>
        <p><strong>Prénom :</strong> {{ $paiement->prenom }}</p>
        <p><strong>Type de Paiement :</strong> {{ $paiement->typepaiement }}</p>
        <p><strong>Montant :</strong> {{ $paiement->montant }} FCFA</p>
        <p><strong>Numéro de Facture :</strong> {{ $paiement->num_facture }}</p>
        <p><strong>État :</strong> {{ $paiement->etat }}</p>
    </div>
    <div class="footer">
        <p>Merci pour votre paiement.</p>
    </div>
</body>
</html>