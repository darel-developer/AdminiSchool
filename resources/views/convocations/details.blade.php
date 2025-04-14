<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocations Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Convocations Details</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Convocations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($convocations as $convocation)
                <tr>
                    <td>{{ $convocation->name }}</td>
                    <td>{{ $convocation->class }}</td>
                    <td>{{ $convocation->convocations }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>