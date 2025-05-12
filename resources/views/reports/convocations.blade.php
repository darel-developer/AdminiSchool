<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Convocations</title>
</head>
<body>
    <h1>Rapport des Convocations</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Total des Convocations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($convocations as $convocation)
                <tr>
                    <td>{{ DateTime::createFromFormat('!m', $convocation->month)->format('F') }}</td>
                    <td>{{ $convocation->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
