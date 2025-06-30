<!-- filepath: c:\xampp\htdocs\AdminiSchool\resources\views\pdf\statistics-simple.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des élèves, matières et notes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #444; padding: 8px; text-align: center; }
        th { background: #357ab8; color: #fff; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Liste des élèves, matières et notes</h2>
    <table>
        <thead>
            <tr>
                <th>Nom de l'élève</th>
                <th>Matière</th>
                <th>Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistics as $stat)
            <tr>
                <td>{{ $stat->student_name }}</td>
                <td>{{ $stat->matiere }}</td>
                <td>{{ number_format($stat->average_grade, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>