<?php
/**
 * Plugin Name: Show Modal To Unregistered Users
 * Plugin URI:  https://github.com/chigozieorunta/wp-show-modal-to-unregistered-users
 * Description: A WordPress plugin that helps site owners display a dialog box to unregistered users who try to access certain areas that require registration.
 * Version:     1.0.0
 * Author:      Chigozie Orunta
 * Author URI:  https://github.com/chigozieorunta
 * License:     MIT
 * Text Domain: wp-show-modal-to-unregistered-users
 * Domain Path: ./
 */

//Define Plugin Path
define("WPSMUU", plugin_dir_path(__FILE__));

wpShowModalToUnregisteredUsers::getInstance();

/**
 * Class wpShowModalUnregisteredUsers
 */
class wpShowModalToUnregisteredUsers {
    /**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
    public function __construct() {
        add_action('enqueue_scripts', array(get_called_class(), 'registerScripts'));
	}
	
	/**
	 * Load only when pluggable.php is ready
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function showModal() {
		$authUsers = array('Administrator', 'Shop Manager', 'SEO Manager');
		$user = wp_get_current_user();
		foreach($authUsers as $key=>$value) {
			$authUsers[$key] = $user->roles[0].' != "'.$value.'"'; 
		}
		$condition = implode(' || ', $authUsers);
		if(is_user_logged_in()) {
			if(isset($user->roles[0]) && ($condition)) {
				add_action('enqueue_scripts', array(get_called_class(), 'registerScripts'));
			}
		} else {
			add_action('enqueue_scripts', array(get_called_class(), 'registerScripts'));
		}
    }

    /**
	 * Register Scripts Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerScripts() {
		wp_register_script('wp-show-modal-to-unregistered-users', plugin_dir_url(__FILE__).'js/wp-show-modal-to-unregistered-users.js');
		wp_enqueue_script('wp-show-modal-to-unregistered-users');
    }

    /**
	 * Points the class, singleton.
	 *
	 * @access public
	 * @since  1.0.0
	 */
    public static function getInstance() {
        static $instance;
        if($instance === null) $instance = new self();
        return $instance;
    }
}

?>