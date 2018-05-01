<?php

namespace App\Http\Sockets;

use Orchid\Socket\BaseSocketListener;
use Ratchet\ConnectionInterface;
use App\Traits\PassportTokenTrait;

class WebSocket extends BaseSocketListener
{
    use PassportTokenTrait;
    /**
     * Current clients.
     *
     * @var \SplObjectStorage
     */
    protected $clients = [];
    const AUTHENTICATION = 'authentication'; //认证
    const SUBSCRIBE = 'subscribe'; //订阅
    const UNSUBSCRIBE = 'unsubscribe'; //退订
    const PUBLISH = 'publish'; //发布
    /**
     * Socket constructor.
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            $data = json_decode($msg);

            if (! is_object($data)) {
                return $this->sendData($from, 'server', '参数格式错误', null, 422);
            }

            // 身份验证
            if (! $this->auth($from, $data)){
                return $this->sendData($from, self::AUTHENTICATION, '认证失败', null, 401);
            }

            // // 签名验证
            // if (! $this->checkoutSign($from, $msg)) {
            //     $from->close();
            //     return ;
            // }
            switch (trim($data->action)) {
                case self::AUTHENTICATION:
                    $this->authentication($from, $data);
                    break;
               
                case self::SUBSCRIBE:
                    $this->subscribe($from, $data);
                    break;

                //     $data =  json_decode($msg);
                //     if ($data->scene == 'paid_result') {
                //         $this->subscribeRealtimePaidResult($client, $msg);
                //     } else {
                //         $this->subscribe($client, $msg);
                //     }
                //     break;
                // case 'notify':
                //     $data =  json_decode($msg);
                //     if ($data->sign == config('socket.secret_key')) {
                //         $this->notifychannel($msg);
                //     }
                //     break;

                default:
                    $this->sendData($from, 'server', '不支持的请求', null, 400);
                    break;
            }

        } catch (\Exception $e) {
            $this->sendData($from, 'server', '服务器错误', null, 500);
            logger($e);
        }

            
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    // 发送数据
    protected function sendData($client, $action, $message, $data=null, $statusCode = 200, $channel=null)
    {
        $client->send(json_encode(
                [
                    'action' => $action,
                    'channel' => $channel,
                    'message' => $message,
                    'data' => $data,
                    'statusCode' => $statusCode
                ]
        ));
    }

    // 解析客户端
    protected function auth($client, $params)
    {
        return isset($params->token) && $this->parseToken($params->token);
    }

    // 身份验证
    protected function authentication($client, $params)
    {
        if (isset($params->token) && ($user = $this->parseToken($params->token)) ) {
            $this->addClient($user, $client);
            $this->sendData($client, self::AUTHENTICATION, '认证成功', $user, 200);
        } else {
            $this->sendData($client, self::AUTHENTICATION, '认证失败', $user, 401);
        }
    }

    // 验证客户端
    protected function verifyClient($conn)
    {
        $client = $this->getClientByConn($conn);
        if (! $client) {
            return $this->sendData($conn, 'client', '非法客户端', null, 400);
        }

        return $client;
    
    }

    // 订阅
    protected function subscribe($conn, $params)
    {
        $client = $this->verifyClient($conn);
        if (isset($params->data->channel)) {
            if (! in_array($params->data->channel, $client->channel)) {
                array_push($client->channel, $params->data->channel);
            }
            return $this->sendData($conn, self::SUBSCRIBE, '订阅频道成功', $client->channel, 200);
        } else {
            return $this->sendData($conn, self::SUBSCRIBE, '订阅频道失败', $client->channel, 400);
        }
    }

    // 退订
    protected function unsubscribe()
    {

    }

    // 发布
    protected function publish()
    {

    }

     // 添加客户端
    public function addClient($user, $conn)
    {
        $client = (object)['user' => $user, 'client' => (object)$conn, 'channel' => []];

        if ($oldClient = $this->getClientByConn($conn)) {
            $this->deleteClient($oldClient);
        }

        $this->clients->attach($client);
        return $client;
    }

    // 根据连接获取客户端
    protected function getClientByConn($conn)
    {
        foreach ($this->clients as $client) {
            if ($client->client == $conn) {
                return $client;
            }
        }
        return null;
    }

    // 删除客户端
    protected function deleteClient($client)
    {
        $this->clients->detach($client);
    }

    // 根据用户获取客户端
    protected function getClientByUser($user)
    {
        foreach ($this->clients as $client) {
            if ($client->user == $user) {
                return $client;
            }
        }
        return null;
    }
}
