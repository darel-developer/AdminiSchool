<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\pdf\cahiertexte.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cahier de Texte - Classe {{ $class }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Cahier de Texte - Classe {{ $class }}</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Matière</th>
                <th>Contenu</th>
                <th>Professeur</th>
                <th>Devoirs</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cahiers as $cahier)
                <tr>
                    <td>{{ $cahier->date ? $cahier->date->format('d/m/Y') : 'Non spécifiée' }}</td>
                    <td>{{ $cahier->matiere }}</td>
                    <td>{{ $cahier->contenu }}</td>
                    <td>{{ $cahier->professeur }}</td>
                    <td>{{ $cahier->devoirs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>