<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/schoolpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
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
            background-color: #2c3e50;
            color: #ecf0f1;
            border-right: 1px solid #34495e;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 20px;
        }
        .sidebar-separator {
            border-top: 1px solid #34495e;
            margin: 10px 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar-item:hover {
            background-color: #34495e;
            color: #ecf0f1;
        }
        .sidebar-item img {
            width: 25px;
            height: 25px;
            margin-right: 15px;
        }
        .sidebar-item.active {
            color: #ffffff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
        <a href="{{route('dashboard')}}" class="sidebar-item">
            <img src="{{ asset('images/Statistics.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('documentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="{{route('eventschool')}}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="event">
            Evenement
        </a>
        <a href="{{route('schoolpaiement')}}" class="sidebar-item active">
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
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
        <a href="{{route('userschool')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="user">
            Users
        </a>
        <a href="{{route('studentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/action.png') }}" alt="user">
            student
        </a>
        <a href="{{ route('create.teacher') }}" class="sidebar-item">
            <img src="{{ asset('images/teacher.png') }}" alt="teacher">
            Create Teacher
        </a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 class="mb-4">Liste des Paiements</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Type de Paiement</th>
                        <th>Montant</th>
                        <th>Numéro de Facture</th>
                        <th>État</th>
                        <th>Action</th>
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
                                <a href="{{ route('showpaiement', $paiement->id) }}" class="btn btn-primary">Verifier</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>