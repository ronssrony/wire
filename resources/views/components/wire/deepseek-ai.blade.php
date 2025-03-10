
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: transparent;
            flex-direction: column;
        }

        #chat-container {
            width: 80%;
            max-width: 600px;
            margin: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #messages {
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
        }

        .message {
            padding: 5px;
            margin: 5px 0;
            border-radius: 4px;
            background: white;
            color: black;
        }

        .user-message {
            text-align: right;
            background: #f9f9f9;
            color: black;
        }

        .user-message .message {
            background: #e0f7fa;
        }

        .ai-message {
            text-align: left;
            background: #f1f1f1;
            padding: 10px;
            border-radius: 4px;
            max-width: 80%;
        }

        #chat-input {
            display: flex;
        }

        #chat-input input {
            flex-grow: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #chat-input button {
            padding: 10px 20px;
            background: #000000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #chat-input button:hover {
            background: #0f0f0f;
        }
    </style>
    <script src="https://js.puter.com/v2/"></script>

</head>

<body>
<div id="chat-container">
    <div id="messages"></div>
    <div id="chat-input">
        <input type="text" id="input-message" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    const messages = [];

    function addMessage(msg, isUser) {
        const messagesDiv = document.getElementById("messages");
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (isUser) {
            messageDiv.classList.add("user-message");
        } else {
            messageDiv.classList.add("ai-message");
        }

        messageDiv.textContent = msg;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        return messageDiv; // Return reference for updating
    }

    async function sendMessage() {
        const input = document.getElementById("input-message");
        const message = input.value.trim();
        if (!message) return;

        addMessage(message, true); // User message
        input.value = '';
        messages.push({ content: message, role: 'user' });

        // Placeholder AI message
        const aiMessageDiv = addMessage("...", false);

        try {
            const resp = await puter.ai.chat(messages, { model: 'claude', stream: true });

            let aiResponse = "";

            for await (const part of resp) {
                aiResponse += part.text;
                aiMessageDiv.textContent = aiResponse; // Update AI message dynamically
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            }

            messages.push({ content: aiResponse, role: 'assistant' });

        } catch (error) {
            aiMessageDiv.textContent = "Error: Unable to fetch response.";
            console.error(error);
        }
    }
</script>
</body>
