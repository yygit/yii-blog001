<?php
// \protected\components\views\chatWidget.php
echo $data;

/* YY; need to save chat window status (opened or closed) into cookie */
Yii::app()->clientScript->registerCoreScript('cookie');

// Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/chat/css/page.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jScrollPane.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/chat/css/chat.css');

Yii::app()->clientScript->registerScript('helloscript2',null,CClientScript::POS_READY); // empty script just to make 'registerScriptFile' autoload jQuery.js

/* YY; chat scripts */
// Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jquery.mousewheel.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/jScrollPane/jScrollPane.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat/js/script.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chat.js',CClientScript::POS_HEAD); 	// YY; Feb 25, 2013 12:59:13 AM;


?>

<div id="chatContainer" style="position: absolute;">
	<div id="left_chat" style="float: left; display: block; width: 22px; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/css/chat/img/left-close.png'); 
		background-repeat: no-repeat;
		overflow: hidden;"></div>
	<div id="center_chat"
		style="float: left; display: block; position: relative; background-color: white; width: 95%;">
		<div id="chatTopBar" class="rounded"></div>
		<div id="chatLineHolder"></div>

		<div id="chatUsers" class="rounded"></div>
		<div id="chatBottomBar" class="rounded">
			<div class="tip"></div>

			<form id="loginForm" method="post" action="">
				<input id="name" name="name" class="rounded" maxlength="16"
					style="width: 80%;" /> <input id="email" name="email"
					class="rounded" style="display: none;" /> <input type="submit"
					class="blueButton" value="Login" />
			</form>

			<form id="submitForm" method="post" action="">
				<input id="chatText" name="chatText" class="rounded" maxlength="255" />
				<input type="submit" class="blueButton" value="Submit" />
			</form>

		</div>
	</div>
	<!--  	<div id="right_chat" style="float: left; display: block; width: 22px; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/css/chat/img/right-open.png'); background-repeat: no-repeat; overflow: hidden;"></div> 	  -->
	<div id="right_chat2"
		style="float: right; display: none; width: 22px; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/css/chat/img/right-open.png'); background-repeat: no-repeat;  overflow: hidden;"></div>
	<div style="clear: both;"></div>



</div>

<!-- YY absolute URL for script.js -->
<div id="absurl" style="display: none;">
	<?php echo Yii::app()->createAbsoluteUrl('chat/ajaxchat');?>
</div>

<!-- YY chat Name for script.js -->
<div id="chatname" style="display: none;">
	<?php echo Yii::app()->user->name;?>
</div>

<!-- YY guest Name for script.js -->
<div id="isguest" style="display: none;">
	<?php echo Yii::app()->user->isGUest;?>
</div>
