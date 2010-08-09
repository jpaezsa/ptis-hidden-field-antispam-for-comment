<?php
/*
Plugin Name: Pti's Hidden Field Antispam for comment
Plugin URI: http://www.ptipti.ru/hiden_field/
Description: A simple plugin wich adds hidden field to comment form, to exclude auto-spam possibility through POST request
Author: Pti_the_Leader
Version: 1.0
Author URI: http://www.ptipti.ru/
*/

session_start();

add_action ('comment_form', 'insert_hidden_field');
add_action ('comment_post', 'check_hidden_field');


function insert_hidden_field ($id) {
	global $user_ID;
	if( $user_ID ) {
		return $id;
	} else {
		$key =  md5 (rand ());
		$_SESSION['hidden_session'] = $key;
		echo '<input type="hidden" name="hidden_form" value="'.$key.'" />';
	}
}

function check_hidden_field ($id) {
	global $user_ID;
	if ($user_ID) {
		return $id;
	} else {
		if ($_SESSION['hidden_session'] != $_POST['hidden_form']) {
			wp_set_comment_status ($id, 'spam');
		}
	}
}
?>