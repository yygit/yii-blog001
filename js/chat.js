/* /blog-yii/js/chat.js */

jQuery(document).ready(function() {
	// alert('/blog-yii/js/chat.js');

	/*
	 * YY; get the height of the chat container and make left and right DIVs of
	 * the same height
	 */
	CC_h = $('#chatContainer').outerHeight();
	$('#left_chat').css('height', CC_h + 'px');
	$('#right_chat').css('height', CC_h + 'px');
	$('#right_chat2').css('height', CC_h + 'px');
	
	body_w = $('body').width();
	container_w = $('body div.container').width();
	$('body div.#chatContainer').css('right',(body_w-container_w)/2 - 10 + 'px');
	

	/* open or close chat window DIVs */
	function toggle_chat_window() {
		$('div#left_chat').toggle();
		$('div#center_chat').toggle();
		$('div#right_chat').toggle();
		$('div#right_chat2').toggle();
	}

	/* check if logged */
	function isLogged() {
		$.tzGET('checkLogged', function(r) {
			if (r.logged) {
				$('#loginForm').fadeOut(function() {
					$('#submitForm').fadeIn();
					$('#chatText').focus();
				});
			}
			else {
				 $('div#chatContainer form#loginForm input[value=Login]').trigger('click');
			}
			
			chat.data.jspAPI.reinitialise();
			chat.data.jspAPI.scrollToBottom(true);
		});
	}
	
	/* open click */
	$(document).on('click', 'div#chatContainer div#right_chat2', function() {
		toggle_chat_window();
		$.cookie("chat_win_status", "opened", {
			path : "/",
			expires : "7"
		});
		
		/* if logged, fade out the login form; if not logged, login as Guest or Username */
		isLogged();
	});

	/* close click */
	$(document).on('click', 'div#chatContainer div#left_chat', function() {
		toggle_chat_window();
		$.cookie("chat_win_status", "closed", {
			path : "/",
			expires : "7"
		});
	});

	/* check upon page load, if 'closed', toggle the chat window */
	chat_win_status = $.cookie("chat_win_status");
	if (chat_win_status == 'closed') {
		toggle_chat_window();
	}
	/* if logged, fade out the login form; if not logged, login as Guest or Username */
	isLogged();
	

});
