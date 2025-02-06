<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/school/filedocument.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents des Parents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Documents des Parents</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom du Parent</th>
                    <th>Document</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $item)
                    <tr>
                        <td>{{ $item->tuteur->nom }}</td>
                        <td>{{ $item->file_path }}</td>
                        <td>
                            <a href="{{ route('school.viewDocument', $item->id) }}" class="btn btn-info" target="_blank">Visualiser</a>
                            <a href="{{ route('school.downloadDocument', $item->id) }}" class="btn btn-success">Télécharger</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>