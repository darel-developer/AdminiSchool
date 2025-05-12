<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Absences</title>
</head>
<body>
    <h1>Rapport des Absences</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Total des Absences</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absences as $absence)
                <tr>
                    <td>{{ DateTime::createFromFormat('!m', $absence->month)->format('F') }}</td>
                    <td>{{ $absence->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
