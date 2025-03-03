<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/showpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tuteurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Liste des Tuteurs</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Numéro de Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tuteurs as $tuteur)
                    <tr>
                        <td>{{ $tuteur->nom }}</td>
                        <td>{{ $tuteur->prenom }}</td>
                        <td>{{ $tuteur->email }}</td>
                        <td>{{ $tuteur->phone_number }}</td>
                        <td>
                            <a href="{{ route('users.edit', $tuteur->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('users.delete', $tuteur->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>