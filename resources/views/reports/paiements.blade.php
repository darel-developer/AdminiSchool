<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Paiements</title>
</head>
<body>
    <h1>Rapport des Paiements</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Total des Paiements</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paiements as $paiement)
                <tr>
                    <td>{{ DateTime::createFromFormat('!m', $paiement->month)->format('F') }}</td>
                    <td>{{ $paiement->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
