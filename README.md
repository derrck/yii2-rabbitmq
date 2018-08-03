# yii2-rabbitmq
yii2 package for RabbitMQ

安装包 Install 
```
composer require derrck/yii2-rabbitmq:dev-master
```
或者到项目中compare.phar的同级目录 or run below code in composer.phar path
```
php composer.phar require --prefer-dist derrck/yii2-rabbitmq "*"
```

config文件中加入配置 add below code to config file
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

使用 Use
```
Yii::$app->rabbitmq->setMessage('messagessss', 'my_queue');
Yii::$app->rabbitmq->getMessage('my_queue', 'your_queue');
```
