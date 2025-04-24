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

    <input type="button" value="Enviar" onclick="enviar()"><br><br>

    <span id="mensagem-chat"></span>
    <script>
        const mensagemChat = window.document.querySelector('span#mensagem-chat')
        const ws = new WebSocket('ws://localhost:8080')

        ws.onopen = (e) => {
            console.log('Conectado!')
        }

        ws.onmessage = (mensagemRecebida) => {
            let resultado = JSON.parse(mensagemRecebida.data)

            mensagemChat.insertAdjacentHTML('beforeend', `${resultado.mensagem} <br>`)
        }

        const enviar = () => {
            let mensagem = window.document.querySelector('input#mensagem')
            
            let dados = {
                mensagem: `${mensagem.value}`
            }

            ws.send(JSON.stringify(dados))

            mensagemChat.insertAdjacentHTML('beforeend', `${mensagem.value} <br>`)

            mensagem.value = '';
        }
    </script>
</body>
</html>