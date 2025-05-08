<!-- filepath: c:\xampp\htdocs\AdminiSchool\resources\views\pdf\cahiertexte.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cahier de Texte - Classe {{ $class }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .table-container {
            width: 90%;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Cahier de Texte - Classe {{ $class }}</h1>
    <div class="table-container">
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
    </div>
    <div class="footer">
        © {{ date('Y') }} AdminiSchool. Tous droits réservés.
    </div>
</body>
</html>