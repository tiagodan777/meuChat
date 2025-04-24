<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <h1>Chat</h1>

    <label for="mensagem">Mensagem</label>
    <input type="text" name="mensagem" id="mensagem">
    <br>
    <input type="button" value="Enviar">
    <br><br>
    <span id="mensagem-chat"></span>

    <script>
        const mensagemChat = window.document.querySelector('span#mensagem-chat')
        const ws = new WebSocket('ws://localhost:8080')

        ws.onopen(
            console.log('Conectado!')
        )
    </script>
</body>
</html>