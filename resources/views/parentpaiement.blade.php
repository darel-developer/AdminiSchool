<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <form id="eventForm" method="POST" action="/events" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4" id="nameFields">
                    <div class="col">
                        <div class="form-outline">
                            <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" value="{{ old('firstName') }}" required />
                            <label class="form-label" for="firstName">First Name</label>
                            @error('firstName')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                            <input type="text" id="secondName" name="secondName" class="form-control" placeholder="Second Name" value="{{ old('secondName') }}" required />
                            <label class="form-label" for="secondName">Second Name</label>
                            @error('secondName')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="mb-1">Select Pzyment Type:</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="accountType" id="parent" value="parent" {{ old('accountType') == 'parent' ? 'checked' : '' }} onclick="toggleFields('parent')" />
                        <label class="form-check-label" for="parent">Pension</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="accountType" id="school" value="school" {{ old('accountType') == 'school' ? 'checked' : '' }} onclick="toggleFields('school')" />
                        <label class="form-check-label" for="school">Other</label>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <input type="email" id="username" name="username" class="form-control" placeholder="Enter the montant" required/>
                    <label class="form-label" for="username">Montant</label>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </div>
</body>
</html>
