<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <h1>Chat</h1>

    <h2>Bem-vindo/a: <?= $_SESSION['nome'] ?></h2>

    <a href="sair.php">Sair</a><br><br>

    <label for="mensagem">Mensagem</label>
    <input type="text" name="mensagem" id="mensagem">
    <br>
    <input type="button" value="Enviar" onclick="enviar()">
    <br><br>
    <span id="mensagem-chat"></span>
    <input type="hidden" name="usuario-id" id="usuario-id" value="<?= $_SESSION['id'] ?>">
    <input type="hidden" name="usuario-nome" id="usuario-nome" value="<?= $_SESSION['nome'] ?>">

    <script>
        const mensagemChat = window.document.querySelector('span#mensagem-chat')
        const ws = new WebSocket('ws://localhost:8080')

        ws.onopen = (e) => (
            console.log('Conectado!')
        )

        ws.onmessage = (mensagemRecebida) => {
            let resultado = JSON.parse(mensagemRecebida.data)

            mensagemChat.insertAdjacentHTML('beforeend', `${resultado.usuarioNome}: ${resultado.mensagem} <br>`)
        }

        const enviar = () => {
            let mensagem = window.document.querySelector('input#mensagem')
            let usuarioId = window.document.querySelector('input#usuario-id')
            let usuarioNome = window.document.querySelector('input#usuario-nome')

            let dados = {
                mensagem: `${mensagem.value}`,
                usuarioId: `${usuarioId.value}`,
                usuarioNome: `${usuarioNome.value}`
            }

            ws.send(JSON.stringify(dados))

            mensagemChat.insertAdjacentHTML('beforeend', `${usuarioNome.value}: ${mensagem.value} <br>`)

            mensagem.value = ''
        }
    </script>
</body>
</html>