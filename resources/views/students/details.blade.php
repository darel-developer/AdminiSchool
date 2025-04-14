<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Students Details</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Enrollment Date</th>
                    <th>Absences</th>
                    <th>Convocations</th>
                    <th>Warnings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->enrollment_date }}</td>
                    <td>{{ $student->absences }}</td>
                    <td>{{ $student->convocations }}</td>
                    <td>{{ $student->warnings }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>