<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des documents</title>
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

        /* Styles personnalisés */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            display: flex;
            flex-direction: column;
            background: #2c3e50;
            border-right: 1px solid #ddd;
            color: #fff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 10px;
        }
        .sidebar-separator {
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            margin: 10px 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            font-size: 0.9rem;
            margin: 5px 0;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        .sidebar-item img {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
            background: #fff;
        }
        .content h1 {
            color: #333;
        }

        /* Styles pour les petits écrans */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 60px;
                flex-direction: row;
                justify-content: space-around;
                padding: 0;
                border-right: none;
                border-top: 1px solid #ddd;
                position: fixed;
                bottom: 0;
                left: 0;
            }
            .sidebar-item {
                flex-direction: column;
                align-items: center;
                padding: 5px;
                font-size: 12px;
            }
            .sidebar-item img {
                margin-right: 0;
                margin-bottom: 5px;
            }
            .content {
                margin: 0;
                padding-bottom: 80px; 
            }
        }

        /* Animation pour l'alerte de succès */
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
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
        <a href="{{route('parent')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="{{route('parentpaiement')}}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Messagerie
        </a>
        <a href="{{ route('notifications.page') }}" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="help support">
            notification
        </a>
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_User.png') }}" alt="help support">
            Ajouter Enfant
        </a>
        <a href="{{route('profileschool')}}" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Paramètres
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 id="main-title">Téléversement des documents</h1>
            <div class="mt-4">
                @if(session('success'))
                    <div class="alert alert-success show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form id="uploadForm" method="POST" action="{{ route('parent.uploadDocument') }}" enctype="multipart/form-data">
                    @csrf <!-- Token de sécurité pour Laravel -->
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Sélectionnez un fichier (pdf)</label>
                        <input type="file" name="documentfile" id="documentFile" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type de document</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="bulletin">Bulletin</option>
                            <option value="autorisation">Autorisation</option>
                            <option value="rapport">Rapport</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3" id="customTypeContainer" style="display: none;">
                        <label for="customType" class="form-label">Entrez le type de document</label>
                        <input type="text" name="custom_type" id="customType" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Téléverser</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('type').addEventListener('change', function () {
            const customTypeContainer = document.getElementById('customTypeContainer');
            if (this.value === 'autre') {
                customTypeContainer.style.display = 'block';
            } else {
                customTypeContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>