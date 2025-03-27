<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message.user {
            text-align: right;
        }
        .chat-message.bot {
            text-align: left;
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
            <form id="chatForm" method="POST" action="{{ route('help.support.send') }}">
                @csrf
                <div class="input-group mt-3">
                    <input type="text" name="message" id="messageInput" class="form-control" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const chatBox = document.getElementById('chatBox');

            // Append user message to chat box
            const userMessage = document.createElement('div');
            userMessage.classList.add('chat-message', 'user');
            userMessage.textContent = messageInput.value;
            chatBox.appendChild(userMessage);

            // Simulate bot response
            setTimeout(() => {
                const botMessage = document.createElement('div');
                botMessage.classList.add('chat-message', 'bot');
                botMessage.textContent = 'Thank you for your message. Our team will get back to you shortly.';
                chatBox.appendChild(botMessage);
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 1000);

            // Clear input
            messageInput.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
</body>
</html>