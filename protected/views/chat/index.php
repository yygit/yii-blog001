<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/chat/css/chat.css');
// Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/chat/css/page.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jScrollPane.css');

Yii::app()->clientScript->registerScript('helloscript2',null,CClientScript::POS_READY); 							// to make 'registerScriptFile' autoload jQuery.js
// Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat.js',CClientScript::POS_HEAD); 	// YY; Feb 25, 2013 12:59:13 AM;

/* YY; chat scripts */
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jquery.mousewheel.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jScrollPane.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/script.js',CClientScript::POS_END);

var_dump($user);
$this->widget('ChatWidget', array('data'=>'this is a test string from chatWidget'));

?>

<div id="chatContainer">

	<div id="chatTopBar" class="rounded"></div>
	<div id="chatLineHolder"></div>

	<div id="chatUsers" class="rounded"></div>
	<div id="chatBottomBar" class="rounded">
		<div class="tip"></div>

		<form id="loginForm" method="post" action="">
			<input id="name" name="name" class="rounded" maxlength="16" style="width:80%;"/> <input
				id="email" name="email" class="rounded" style="display:none;"/> <input type="submit"
				class="blueButton" value="Login" />
		</form>

		<form id="submitForm" method="post" action="">
			<input id="chatText" name="chatText" class="rounded" maxlength="255" />
			<input type="submit" class="blueButton" value="Submit" />
		</form>

	</div>

</div>

<!-- YY absolute URL for script.js -->
<div id="absurl" style="display:none;"><?php echo Yii::app()->createAbsoluteUrl('chat/ajaxchat');?></div>
