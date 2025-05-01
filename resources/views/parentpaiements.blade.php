<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\parentpaiements.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Liste des Paiements</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Type de Paiement</th>
                    <th>Montant</th>
                    <th>Numéro de Facture</th>
                    <th>État</th>
                    <th>Facture</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->nom }}</td>
                        <td>{{ $paiement->prenom }}</td>
                        <td>{{ $paiement->typepaiement }}</td>
                        <td>{{ $paiement->montant }}</td>
                        <td>{{ $paiement->num_facture }}</td>
                        <td>{{ $paiement->etat }}</td>
                        <td>
                            <div class="mt-3">
                                <a href="{{ route('paiement.facture', $paiement->id) }}" class="btn btn-secondary" target="_blank">Voir la Facture</a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('paiement.download', $paiement->id) }}" class="btn btn-success">
                                <i class="fas fa-download"></i> Télécharger la Facture
                            </a> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('parentpaiement') }}" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>