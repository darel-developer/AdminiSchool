<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #ee7724, #d8363a, #dd3675, #b44593);
            color: #fff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .content h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="sidebar">
        <a href="{{route('parent')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <h1 id="main-title">Ajouter un événement</h1>
        <div class="mt-4">
           <!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/parentpaiement.blade.php -->
<form id="paiementForm" method="POST" action="{{ route('paiement.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row mb-4" id="nameFields">
        <div class="col">
            <div class="form-outline">
                <input type="text" id="firstName" name="nom" class="form-control" placeholder="First Name" value="{{ old('nom') }}" required />
                <label class="form-label" for="firstName">First Name</label>
                @error('nom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-outline">
                <input type="text" id="secondName" name="prenom" class="form-control" placeholder="Second Name" value="{{ old('prenom') }}" required />
                <label class="form-label" for="secondName">Second Name</label>
                @error('prenom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-4">
        <p class="mb-1">Select Payment Type:</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="typepaiement" id="pension" value="pension" {{ old('typepaiement') == 'pension' ? 'checked' : '' }} />
            <label class="form-check-label" for="pension">Pension</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="typepaiement" id="other" value="other" {{ old('typepaiement') == 'other' ? 'checked' : '' }} />
            <label class="form-check-label" for="other">Other</label>
        </div>
    </div>

    <div class="form-outline mb-4">
        <input type="number" id="montant" name="montant" class="form-control" placeholder="Enter the montant" value="{{ old('montant') }}" required/>
        <label class="form-label" for="montant">Montant</label>
        @error('montant')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-outline mb-4">
        <input type="text" id="factureNumber" name="num_facture" class="form-control" placeholder="Enter the facture number" value="{{ old('num_facture') }}" required/>
        <label class="form-label" for="factureNumber">Facture Number</label>
        @error('num_facture')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
            <!-- Button to view all payments -->
            <a href="{{ route('parent.paiements') }}" class="btn btn-secondary mt-3">Voir tous les paiements</a>
        </div>
    </div>
</body>
</html>