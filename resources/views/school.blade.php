<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des données des élèves</title>
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
            background-color: #343a40;
            color: white;
            padding: 15px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
        }
        .sidebar-item {
            margin-bottom: 15px;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }
        .sidebar-item img {
            margin-right: 10px;
        }
        .sidebar-item:hover {
            background-color: #495057;
            border-radius: 5px;
            padding: 10px;
        }
        .content {
            margin-left: 250px; /* Adjust this value to match the sidebar width */
            padding: 20px;
            flex-grow: 1;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
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
        <div class="container mt-5">
            <h1 id="main-title">Téléversement des données des élèves</h1>
            <div class="mt-4">
                <form id="uploadForm" method="POST" action="{{ route('import.upload') }}" enctype="multipart/form-data">
                    @csrf <!-- Token de sécurité pour Laravel -->
                    <div class="mb-3">
                        <label for="studentFile" class="form-label">Sélectionnez un fichier (Excel, TXT, CSV)</label>
                        <input type="file" name="studentFile" id="studentFile" class="form-control" accept=".xlsx, .xls, .csv, .txt" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Téléverser</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>