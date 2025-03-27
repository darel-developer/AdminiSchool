<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/edit-tuteur.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Tuteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier le Tuteur</h1>
        <form method="POST" action="{{ route('users.update', $tuteur->id) }}">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ $tuteur->nom }}" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $tuteur->prenom }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $tuteur->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Numéro de Téléphone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $tuteur->phone_number }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>