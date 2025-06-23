<!-- filepath: c:\xampp\htdocs\AdminiSchool\resources\views\pdf\statistics-simple.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des élèves et matières</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Liste des élèves et matières</h2>
    <table>
        <thead>
            <tr>
                <th>Nom de l'élève</th>
                <th>Matière</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistics as $stat)
                <tr>
                    <td>{{ $stat->student_name }}</td>
                    <td>{{ $stat->matiere }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>