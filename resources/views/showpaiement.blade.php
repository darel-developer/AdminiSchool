<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/showpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Détails du Paiement</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $paiement->nom }} {{ $paiement->prenom }}</h5>
                <p class="card-text">Type de Paiement: {{ $paiement->typepaiement }}</p>
                <p class="card-text">Montant: {{ $paiement->montant }}</p>
                <p class="card-text">Numéro de Facture: {{ $paiement->num_facture }}</p>
                <p class="card-text">État: {{ $paiement->etat }}</p>
                <form method="POST" action="{{ route('paiement.update', $paiement->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="etat">Changer l'état du paiement:</label>
                        <select name="etat" id="etat" class="form-control">
                            <option value="en attente" {{ $paiement->etat == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="approuver" {{ $paiement->etat == 'approuver' ? 'selected' : '' }}>Approuver</option>
                            <option value="refuser" {{ $paiement->etat == 'refuser' ? 'selected' : '' }}>Refuser</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>