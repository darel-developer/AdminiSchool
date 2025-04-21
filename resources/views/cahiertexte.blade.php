<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Cahier de Texte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .class-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        .class-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestion du Cahier de Texte</h1>

    <!-- Bouton pour ouvrir la fenêtre modale -->
    <button class="btn btn-primary mb-4 float-end" data-bs-toggle="modal" data-bs-target="#uploadModal">
        <i class="fas fa-plus"></i> Ajouter un Cahier de Texte
    </button>
</br>
</br>
</br>

    <!-- Fenêtre modale pour téléverser un document -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Téléverser un Cahier de Texte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cahiertexte.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Fichier Excel</label>
                            <input type="file" name="fichier" id="file" class="form-control" accept=".xlsx, .xls" required>
                            <div class="form-text">Format attendu : Colonnes "date", "matiere", "contenu", "professeur", "devoirs".</div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Téléverser</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteneurs pour chaque classe -->
    @foreach (['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale'] as $classe)
        <div class="class-container">
            <div class="class-header">Classe : {{ $classe }}</div>
            <div class="action-buttons">
                <a href="{{ route('cahiertexte.show', ['class' => $classe]) }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Consulter le Cahier de Texte
                </a>
                <form action="{{ route('cahiertexte.destroy', ['class' => $classe]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer le cahier de texte ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer le Cahier de Texte
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
