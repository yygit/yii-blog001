<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('helloscript2',null,CClientScript::POS_READY); // to make 'registerScriptFile' autoload jQuery.js

var_dump($user);
$this->widget('ChatWidget', array('data'=>'test string from chatWidget'));

