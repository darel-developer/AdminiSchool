<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
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
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .dashboard-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .dashboard-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('school')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            ROLL
        </a>
        <a href="{{ route('documentschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Documents
        </a>
        <a href="{{ route('eventschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="event">
            Events
        </a>
        <a href="{{ route('schoolpaiement') }}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="payment">
            Payments
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 class="text-center mb-4">Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('students.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Students</div>
                            <div class="dashboard-value">{{ $studentCount }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('convocations.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Convocations</div>
                            <div class="dashboard-value">{{ $convocationCount }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('absences.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Absences</div>
                            <div class="dashboard-value">{{ $absenceCount }}</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Recent Activities</h5>
                        <ul>
                            <li>New student enrolled</li>
                            <li>Teacher added to the system</li>
                            <li>Event created</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5>Notifications</h5>
                        <ul>
                            <li>Payment due for 5 students</li>
                            <li>3 absences reported today</li>
                            <li>Convocation scheduled for tomorrow</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>