<?php
require_once __DIR__ . '/vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use TiagoDaniel\WebSocket\SistemaChat;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new SistemaChat()
        )
    ),
    8080
);

$server->run();