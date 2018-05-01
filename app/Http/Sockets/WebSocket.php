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
    protected $clients;
    const AUTHENTICATION = 'authentication';
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
        $this->clients->attach($conn);
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
                return $this->sendData($from, 'server', '参数格式错误', 500);
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
               
                // case 'subscribe':
                //     $client = $this->getClientByContent($from, $msg);
                //     if (! $client) {
                //         return ;
                //     }

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
                    $this->sendData($from, 'server', '不支持的请求', null, 500);
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

    // 身份验证
    protected function authentication($client, $params)
    {
        if (isset($params->data->token) && ($user = $this->parseToken($params->data->token)) ) {
            $this->sendData($client, self::AUTHENTICATION, '认证成功', $user, 200);
        } else {
            $this->sendData($client, self::AUTHENTICATION, '认证失败', $user, 401);
        }
    }
}
