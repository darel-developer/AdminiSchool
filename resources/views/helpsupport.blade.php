<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .chat-container {
            max-width: 600px;
            margin: 40px auto 0 auto;
            padding: 28px 28px 18px 28px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
        }
        .chat-container h1 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 18px;
            text-align: center;
        }
        .chat-box {
            height: 340px;
            overflow-y: scroll;
            padding: 16px 10px;
            border: 1.5px solid #e3e6ea;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-bottom: 10px;
        }
        .chat-message {
            margin-bottom: 10px;
            padding: 10px 16px;
            border-radius: 12px;
            max-width: 85%;
            display: inline-block;
            font-size: 1rem;
            word-break: break-word;
        }
        .chat-message.user {
            text-align: right;
            background: #e8f0fe;
            color: #22304f;
            float: right;
            clear: both;
        }
        .chat-message.bot {
            text-align: left;
            background: #007bff;
            color: #fff;
            float: left;
            clear: both;
        }
        .alert {
            border-radius: 8px;
        }
        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }
        .btn-primary {
            border-radius: 0 8px 8px 0;
            font-weight: 500;
        }
        @media (max-width: 991.98px) {
            .chat-container {
                max-width: 90vw;
                padding: 16px 8px 12px 8px;
            }
        }
        @media (max-width: 767.98px) {
            .chat-container {
                max-width: 98vw;
                padding: 10px 2vw 8px 2vw;
            }
            .chat-box {
                height: 220px;
                padding: 8px 2px;
            }
            .chat-message {
                font-size: 0.97rem;
                padding: 8px 8px;
            }
        }
        @media (max-width: 575.98px) {
            .chat-container {
                max-width: 100vw;
                padding: 6px 1vw 4px 1vw;
            }
            .chat-box {
                height: 130px;
                padding: 6px 1vw;
            }
            .chat-message {
                font-size: 0.95rem;
                padding: 6px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="chat-container">
            <h1>Help Support</h1>
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="chat-box" id="chatBox">
                <!-- Messages will be appended here -->
            </div>
            <form id="chatForm" method="POST">
                @csrf
                <div class="input-group mt-3">
                    <input type="text" name="message" id="messageInput" class="form-control" placeholder="Posez votre question sur l'utilisation de l'application..." required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const chatBox = document.getElementById('chatBox');
            const userMessage = messageInput.value.trim();
            if (!userMessage) return;

            // Affiche le message utilisateur
            const userDiv = document.createElement('div');
            userDiv.classList.add('chat-message', 'user');
            userDiv.textContent = userMessage;
            chatBox.appendChild(userDiv);
            chatBox.scrollTop = chatBox.scrollHeight;

            // Envoie la question au contrôleur Laravel pour obtenir la réponse du bot
            fetch("{{ route('help.support.bot') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                const botDiv = document.createElement('div');
                botDiv.classList.add('chat-message', 'bot');
                botDiv.textContent = data.reply;
                chatBox.appendChild(botDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(() => {
                const botDiv = document.createElement('div');
                botDiv.classList.add('chat-message', 'bot');
                botDiv.textContent = "Désolé, une erreur est survenue. Veuillez réessayer.";
                chatBox.appendChild(botDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            messageInput.value = '';
        });
    </script>
</body>
</html>