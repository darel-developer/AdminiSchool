<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 82%;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 10px 0;
            font-size: 28px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .details {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .details p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .details strong {
            color: #000;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: #fff;
            font-size: 14px;
        }
        table td {
            font-size: 14px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature img {
            max-width: 150px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo de l'école">
            <h1>ADMINISCHOOL</h1>
            <p><em>"Apprendre aujourd'hui pour réussir demain"</em></p>
            <p>Adresse: Yaoundé, Cameroun, Derrière pharmacie bleu</p>
        </div>

        <!-- Détails du client -->
        <div class="details">
            <p><strong>Nom:</strong> {{ $paiement->nom }}</p>
            <p><strong>Prénom:</strong> {{ $paiement->prenom }}</p>
            <p><strong>Numéro de Facture:</strong> {{ $paiement->num_facture }}</p>
            <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>

        <!-- Tableau des détails du paiement -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Type de Paiement</th>
                        <th>Montant</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $paiement->typepaiement }}</td>
                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                        <td>{{ ucfirst($paiement->etat) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature -->
        <div class="signature">
            <p>Signature numérique:</p>
            <img src="{{ asset('images/signature.png') }}" alt="Signature">
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre paiement</p>
            <p>Pour toute question, contactez-nous au +237 6XX XXX XXX</p>
        </div>
    </div>
</body>
</html>