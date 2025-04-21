<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\cahiertexte\show.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cahier de Texte - Classe {{ $class }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Cahier de Texte - Classe {{ $class }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route('cahiertexte.download', ['class' => $class]) }}" class="btn btn-success mb-3 float-end">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/download.png" alt="Download" style="width: 20px; height: 20px; margin-right: 5px;">
        Télécharger le PDF
    </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Matière</th>
                <th>Contenu</th>
                <th>Professeur</th>
                <th>Devoirs</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cahiers as $cahier)
                <tr>
                    <td>{{ $cahier->date ? $cahier->date->format('d/m/Y') : 'Non spécifiée' }}</td>
                    <td>{{ $cahier->matiere }}</td>
                    <td>{{ $cahier->contenu }}</td>
                    <td>{{ $cahier->professeur }}</td>
                    <td>{{ $cahier->devoirs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cahiertexte') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
</body>
</html>