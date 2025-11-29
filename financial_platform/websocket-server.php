<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\Server as ReactSocketServer;
use React\EventLoop\Factory;

// Implementacija WebSocket servera
class WebSocketServer implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "Nova konekcija: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Poruka od korisnika {$from->resourceId}: $msg\n";
        $from->send("Odgovor: $msg");
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Konekcija zatvorena: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Greška: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Kreiramo event loop koristeći React
$loop = Factory::create();

// Kreiramo React Socket server na portu 8080
$socket = new ReactSocketServer('0.0.0.0:8080', $loop);

// Kreiramo Ratchet WebSocket server
$wsServer = new WsServer(new WebSocketServer());

// Kreiramo IoServer sa React Socket serverom
$ioServer = IoServer::factory(
    $wsServer,  // WebSocket server
    $socket     // React Socket server
);

// Pokrećemo server
echo "Pokrećemo WebSocket server na ws://localhost:8080\n";
$ioServer->run();