# yii2-rabbitmq
yii2 package for RabbitMQ

Install 安装包
```
composer require derrck/yii2-rabbitmq:dev-master
```
或者到项目中compare.phar的同级目录
```
php composer.phar require --prefer-dist derrck/yii2-rabbitmq "*"
```

config文件中加入配置
```
return [
	// [...]
	'components'=>[
		// [...]
		'rabbitmq' => [
            'class' => '\derrck\yii2\rabbitmq',
            'host' => '127.0.0.1',
            'port' => '5672',
            'user' => 'guest',
            'password' => 'guest',
            'vhost' => '/',
        ],
	// [...]
];
```

使用
```
Yii::$app->rabbitmq->setMessage('messagessss', 'my_queue');
Yii::$app->rabbitmq->getMessage('my_queue', 'your_queue');
```
