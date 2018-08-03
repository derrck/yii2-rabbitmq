<?php
namespace derrck\yii2;

use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class rabbitmq extends Component{

    public $host;
    public $port;
    public $user;
    public $password;
    public $vhost;
    private $channel;
    private $e_name = 'default_name';
    private $k_route = 'default_route';

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->channel = $this->createChannel();
    }

    public function rabbitConfig()
    {
        $config = [
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'password' => $this->password,
            'vhost' => $this->vhost,
        ];
        return $config;
    }

    protected function createChannel()
    {
        $rabbit_config = $this->rabbitConfig();
        $connect = new \AMQPConnection($rabbit_config);

        if (!$connect->connect()) {
            return false;
        }

        $channel = new \AMQPChannel($connect);

        return $channel;
    }

    /**
     * publis message to rabbitMQ
     * @param string $message The name of the exchange to set as string.
     *               The message to publish.
     * @param string $k_route The optional routing key to which to
     *               publish to.
     * @param string $e_name
     */
    public function setMessage($message,$k_route='',$e_name='')
    {
        if(empty($e_name)){
            $e_name = $this->e_name;
        }

        if(empty($k_route)){
            $k_route = $this->k_route;
        }
        $channel = $this->channel;

        $ex = new \AMQPExchange($channel);
        $ex->setName($e_name);//创建名字
        $ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型
        $ex->setFlags(AMQP_DURABLE); //持久化
        $ex->declareExchange();
        $ex->publish($message,$k_route);
    }

    /**
     * get rabbitMQ queue
     * @param $k_route
     * @param $q_name
     * @return \AMQPEnvelope|bool|string
     */
    public function getMessage($k_route,$q_name){
        $channel = $this->channel;
        $q = new \AMQPQueue($channel);
        $q->setName($q_name);
        $q->setFlags(AMQP_DURABLE);
        $q->declareQueue();
        $q->bind($this->e_name, $k_route);
        $messages = $q->get(AMQP_AUTOACK);
        if(is_object( $messages))
            return $messages->getBody();
        return $messages;
    }
}
?>
