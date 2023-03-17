<?php

namespace process;

use app\service\ChatService;
use Workerman\Connection\TcpConnection;

class Websocket
{
    public function onConnect(TcpConnection $connection)
    {

    }

    public function onWebSocketConnect(TcpConnection $connection, $http_buffer)
    {

    }

    public function onMessage(TcpConnection $connection, $data)
    {
        $msg = json_decode($data, true);
        if (isset($msg['token'])) {
            $user_id = getUserId($msg['token']);
            if ($user_id) {
                //请求openai
                $service = new ChatService();
                $service->chat($connection, $msg['content'], $user_id);
            }
        }
        $connection->send(json_encode(['event' => 'close', 'content' => '']));
    }

    public function onClose(TcpConnection $connection)
    {

    }
}