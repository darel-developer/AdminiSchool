<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un enfant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter un enfant</h1>
        <form method="POST" action="{{ route('parent.addChild') }}">
            @csrf
            <div class="mb-3">
                <label for="childName" class="form-label">Nom de l'enfant</label>
                <input type="text" class="form-control" id="childName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Classe</label>
                <select class="form-control" id="class" name="class_id" required>
                    <option value="6ème">6ème</option>
                    <option value="5ème">5ème</option>
                    <option value="4ème">4ème</option>
                    <option value="3ème">3ème</option>
                    <option value="2nde">2nde</option>
                    <option value="1ère">1ère</option>
                    <option value="Terminale">Terminale</option>
                </select>
            </div>
            <input type="hidden" name="tuteur_id" value="{{ auth()->guard('tuteur')->user()->id }}">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>