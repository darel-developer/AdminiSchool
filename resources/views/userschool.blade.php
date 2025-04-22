<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/showpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tuteurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
</head>
<body>
    <div class="container mt-5">
        <h1>Liste des Tuteurs</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table des tuteurs -->
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

    <!-- Fenêtre modale -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un Tuteur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Numéro de Téléphone</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ouvrir automatiquement la fenêtre modale au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });
    </script>
</body>
</html>