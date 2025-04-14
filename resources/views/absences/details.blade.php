<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Absences Details</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Absences</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absences as $absence)
                <tr>
                    <td>{{ $absence->name }}</td>
                    <td>{{ $absence->class }}</td>
                    <td>{{ $absence->absences }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>