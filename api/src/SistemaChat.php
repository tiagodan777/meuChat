<?php
namespace TiagoDaniel\WebSockets;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;

class SistemaChat implements MessageComponentInterface {
    private $client;

    public function __construct()
    {
        $this->client = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->client->attach($conn);

        echo "Nova conexão: {$conn->resourceId}";
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        foreach ($this->client as $client) {
            if ($conn != $client) {
                $client->send($msg);
            }
        }
    }
    
    public function onClose(ConnectionInterface $conn)
    {
        $this->client->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->close();

        echo "Ocorreu um erro: {$e->getMessage()}";
    }
}