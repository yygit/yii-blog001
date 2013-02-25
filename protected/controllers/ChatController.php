<?php

class ChatController extends Controller {
	public $layout='column1';
	private $dbOptions=array();

	/**
	 * @return array action filters
	 */
	public function filters() 	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 	{
		return array(
				array('allow',  // allow all users to access
						'actions'=>array('index','index2', 'ajaxchat'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated users to access all actions
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}


	public function actionIndex() 	{
		$userobj = new User;
		$user = $userobj->findByPk(1)->getAttributes();
		$this->render('index', array('user'=>$user));
	}

	public function actionIndex2() 	{
		$this->render('index2', array('get'=>$_GET));
	}

	public function actionAjaxchat() 	{

		/* Database Configuration. Add your details below */
		$this->dbOptions = array(
				'db_host' => 'localhost',
				'db_user' => 'softlogic',
				'db_pass' => 'softlogic',
				'db_name' => 'softlogic'
		);
		/* Database Config End */

		error_reporting(E_ALL ^ E_NOTICE);

		/* 		require "classes/DB.class.php";
		 require "classes/Chat.class.php";
		require "classes/ChatBase.class.php";
		require "classes/ChatLine.class.php";
		require "classes/ChatUser.class.php";
		*/
		session_name('webchat');
		session_start();

		if(get_magic_quotes_gpc()){
			// If magic quotes is enabled, strip the extra slashes
			array_walk_recursive($_GET,create_function('&$v,$k','$v = stripslashes($v);'));
			array_walk_recursive($_POST,create_function('&$v,$k','$v = stripslashes($v);'));
		}

		try{

			// Connecting to the database
			DB::init($this->dbOptions);

			$response = array();

			// Handling the supported actions:

			switch($_GET['action']){

				case 'login':
					$response = Chat::login($_POST['name'],$_POST['email']);
					break;

				case 'checkLogged':
					$response = Chat::checkLogged();
					break;

				case 'logout':
					$response = Chat::logout();
					break;

				case 'submitChat':
					$response = Chat::submitChat($_POST['chatText']);
					break;

				case 'getUsers':
					$response = Chat::getUsers();
					break;

				case 'getChats':
					$response = Chat::getChats($_GET['lastID']);
					break;

				default:
					throw new Exception('Wrong action: '.$_GET['action']);
			}

			echo json_encode($response);
		}
		catch(Exception $e){
			die(json_encode(array('error' => $e->getMessage())));
		}




		$this->render('index', array('user'=>$user));
	}


}