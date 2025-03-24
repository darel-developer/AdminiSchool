<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            margin: 20px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>École XYZ</h1>
        <p>Adresse de l'école</p>
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
        <p>Signature numérique</p>
    </div>
    <div class="footer">
        <p>Merci pour votre paiement</p>
    </div>
</body>
</html>