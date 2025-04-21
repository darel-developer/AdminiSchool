<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\pdf\planning.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
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
    </style>
</head>
<body>
    <h1>Planning de la classe {{ $student->class }}</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Code</th>
                <th>Enseignant</th>
                <th>Salle</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($planning as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->start_time }}</td>
                    <td>{{ $item->end_time }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->teacher }}</td>
                    <td>{{ $item->room }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>