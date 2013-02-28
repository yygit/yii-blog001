<?php

/* The Chat class exploses public static methods, used by ajax.php */

class Chat{

	public static function login_bak($name,$email){ // YY; backing original func
		if(!$name || !$email){
			throw new Exception('Fill in all the required fields.');
		}

		if(!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
			throw new Exception('Your email is invalid.');
		}

		// Preparing the gravatar hash:
		$gravatar = md5(strtolower(trim($email)));

		$user = new ChatUser(array(
				'name'		=> $name,
				'gravatar'	=> $gravatar
		));

		// The save method returns a MySQLi object
		if($user->save()->affected_rows != 1){
			throw new Exception('This nick is in use.');
		}

		$_SESSION['chat']['user']	= array(
				'name'		=> $name,
				'gravatar'	=> $gravatar
		);

		return array(
				'status'	=> 1,
				'name'		=> $name,
				'gravatar'	=> Chat::gravatarFromHash($gravatar)
		);
	}

	public static function login($name,$email=NULL){
		if(!$name){
			throw new Exception('Fill in the name.');
		}

		/* YY. add random number to Guest name */
		if (strtolower($name) == strtolower(Yii::app()->user->guestName)) {
			$name .= rand(100, 999);
		}

		// Preparing the gravatar hash:
		$gravatar = md5(strtolower(trim($name)));

		$user = new ChatUser(array(
				'name'		=> $name,
				'gravatar'	=> $gravatar
		));

		// check if name already exists, except for Guests
		if( ($user->checkname()->affected_rows > 0) AND (strtolower($name) != strtolower(Yii::app()->user->guestName)) ){
			throw new Exception('This nick is in use.');
		}

		$_SESSION['chat']['user']	= array(
				'name'		=> $name,
				'gravatar'	=> $gravatar
		);

		return array(
				'status'	=> 1,
				'name'		=> $name,
				'gravatar'	=> Chat::gravatarFromHash($gravatar)
		);
	}

	/*  YY; check if chat tables exist, if not, create schema (structure) */
	public static function checkChatTables(){
		$webchat_lines_exists = Yii::app()->db->getSchema()->getTable('webchat_lines');
		if(!$webchat_lines_exists){
			$command = Yii::app()->db->createCommand('CREATE TABLE `webchat_lines` (
					`id` int(10) unsigned NOT NULL auto_increment,
					`author` varchar(16) NOT NULL,
					`gravatar` varchar(32) NOT NULL,
					`text` varchar(255) NOT NULL,
					`ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
					PRIMARY KEY  (`id`),
					KEY `ts` (`ts`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;')->execute();
		}
		
		$webchat_users_exists = Yii::app()->db->getSchema()->getTable('webchat_users');
		if(!$webchat_users_exists){
			$command2 = Yii::app()->db->createCommand('CREATE TABLE `webchat_users` (
					`id` int(10) unsigned NOT NULL auto_increment,
					`name` varchar(16) NOT NULL,
					`gravatar` varchar(32) NOT NULL,
					`last_activity` timestamp NOT NULL default CURRENT_TIMESTAMP,
					PRIMARY KEY  (`id`),
					UNIQUE KEY `name` (`name`),
					KEY `last_activity` (`last_activity`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;')->execute();
		}
	}
	
	public static function checkLogged(){
		
		/*  YY; check if chat tables exist, if not, create schema */
		self::checkChatTables();
		
		$response = array('logged' => false);
			
		if($_SESSION['chat']['user']['name']){
			$response['logged'] = true;
			$response['loggedAs'] = array(
					'name'		=> $_SESSION['chat']['user']['name'],
					'gravatar'	=> Chat::gravatarFromHash($_SESSION['chat']['user']['gravatar'])
			);
		}

		return $response;
	}

	public static function logout(){
		DB::query("DELETE FROM webchat_users WHERE name = '".DB::esc($_SESSION['chat']['user']['name'])."'");

		$_SESSION['chat'] = array();
		unset($_SESSION['chat']);

		return array('status' => 1);
	}

	public static function submitChat($chatText){
		if(!$_SESSION['chat']['user']){
			throw new Exception('You are not logged in');
		}

		if(!$chatText){
			throw new Exception('You haven\' entered a chat message.');
		}

		$chat = new ChatLine(array(
				'author'	=> $_SESSION['chat']['user']['name'],
				'gravatar'	=> $_SESSION['chat']['user']['gravatar'],
				// 'text'		=> $chatText
				'text' => mb_substr($chatText, 0, 100) 	// YY; 1.8. Message should be limited to 100 characters (characters, not bytes)
		));

		// The save method returns a MySQLi object
		$insertID = $chat->save()->insert_id;

		return array(
				'status'	=> 1,
				'insertID'	=> $insertID
		);
	}

	public static function getUsers(){
		if($_SESSION['chat']['user']['name']){
			$user = new ChatUser(array('name' => $_SESSION['chat']['user']['name']));
			$user->update();
		}

		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		DB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
		DB::query("DELETE FROM webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:30')");

		// YY; delete all messages but the latest N
		DB::query("DELETE FROM webchat_lines WHERE id NOT IN (SELECT id FROM (SELECT id FROM webchat_lines ORDER BY id DESC LIMIT 15) foo)");

		$result = DB::query('SELECT * FROM webchat_users ORDER BY name ASC LIMIT 18');

		$users = array();
		while($user = $result->fetch_object()){
			$user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
			$users[] = $user;
		}

		return array(
				'users' => $users,
				'total' => DB::query('SELECT COUNT(*) as cnt FROM webchat_users')->fetch_object()->cnt
		);
	}

	public static function getChats($lastID){
		$lastID = (int)$lastID;

		$result = DB::query('SELECT * FROM webchat_lines WHERE id > '.$lastID.' ORDER BY id ASC');

		$chats = array();
		while($chat = $result->fetch_object()){

			// Returning the GMT (UTC) time of the chat creation:

			$chat->time = array(
					'hours'		=> gmdate('H',strtotime($chat->ts)),
					'minutes'	=> gmdate('i',strtotime($chat->ts))
			);

			$chat->gravatar = Chat::gravatarFromHash($chat->gravatar);

			/* YY; */
			$chat->date = gmdate('j-M-Y',strtotime($chat->ts));

			$chats[] = $chat;
		}

		return array('chats' => $chats);
	}

	public static function gravatarFromHash($hash, $size=23){
		return 'http://www.gravatar.com/avatar/'.$hash.'?size='.$size.'&amp;default='.
				urlencode('http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?size='.$size);
	}
}


?>