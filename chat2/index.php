<?php
session_start();

require_once './src/dbConnection.php';

if (isset($_SESSION['nome'])) {
    header('Location: chat.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $email = $dados['email'];
    
    $sql = "SELECT id, nome, email, password
            FROM usuarios
            WHERE email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute([$email]);

    $usuario = $statement->fetch();

    if ($usuario) {
        if (password_verify($dados['password'], $usuario['password'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header('Location: chat.php');
        } else {
            $msg = "Email ou password incorretos";
        }
    } else {
        $msg = "Email ou password incorretos";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <span style="color: #ff0000;"><?= $msg ?></span><br><br>
    <form action="index.php" method="post">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email"><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password"><br><br>
        <input type="submit" value="Log in">
    </form>
</body>
</html>