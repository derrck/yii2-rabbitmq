<?php
    namespace derrck\yii2;

    use yii\base\Component;

    class rabbitmq {

        public $password;
        public function hello()
        {
            var_dump($this->password);
            return 'hello';
        }
    }
?>
