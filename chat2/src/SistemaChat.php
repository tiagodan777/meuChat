<?php
namespace TiagoDaniel\WebSocket;

use Exception;
use PDO;
use PDOException;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;

class SistemaChat implements MessageComponentInterface {
    private $client;
    private $type = "mysql";
    private $host = "localhost";
    private $dbname = "meuChat";
    private $port = "8889";
    private $charset = "utf8mb4";
    private $username = "root";
    private $password = "root";
    private $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    ];
    private $pdo;

    public function __construct()
    {
        $this->client = new SplObjectStorage();

        try {
            $this->pdo = new PDO("{$this->type}:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;host={$this->host};dbname={$this->dbname};port={$this->port};charset={$this->charset};", $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->client->attach($conn);

        echo "Nova conexão: {$conn->resourceId}";
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        foreach ($this->client as $client) {
            if ($client != $conn) {
                $client->send($msg);
            }
        }

        $this->guardarMensagem($msg);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->client->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->close();

        echo "Erro! Ocorreu um erro com WebSocket: {$e->getMessage()}";
    }

    public function guardarMensagem($request) {
        $request = json_decode($request, true);

        $sql = "INSERT INTO mensagens (mensagem, usuario_id) 
                VALUES (:mensagem, :usuario_id);";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$request['mensagem'], $request['usuarioId']]);
        return true;
    }
}