<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour le paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        .alert {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }
        .alert.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Mettre à jour le paiement</h1>
        @if(session('success'))
            <div class="alert alert-success show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('paiement.update', $paiement->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="etat" class="form-label">État</label>
                <select class="form-control" id="etat" name="etat" required>
                    <option value="en attente" {{ $paiement->etat == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="payé" {{ $paiement->etat == 'payé' ? 'selected' : '' }}>Payé</option>
                    <option value="annulé" {{ $paiement->etat == 'annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 3000); // Masquer l'alerte après 3 secondes
            }
        });
    </script>
</body>
</html>