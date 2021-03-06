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
		add_action('plugins_loaded', array($this, 'showModal'));
		add_action('get_footer', array($this, 'customModal'));
	}
	
	/**
	 * Load only when pluggable.php is ready
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function showModal() {
		//Get user role
		$user = wp_get_current_user();
		
		//Test Condition
		if(is_user_logged_in() && isset($user->roles[0])) {
			if($user->roles[0] != 'administrator' && $user->roles[0] != 'shop_manager' && $user->roles[0] != 'wpseo_manager') {
				add_action('wp_enqueue_scripts', array(get_called_class(), 'registerScripts'));
			}
		} else {
			add_action('wp_enqueue_scripts', array(get_called_class(), 'registerScripts'));
		}
	}
	
	/**
	 * Custom Modal Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function customModal() {
        require_once('wp-show-modal-to-unregistered-users-html.php');
    }

    /**
	 * Register Scripts Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerScripts() {
		wp_register_style('wp-show-modal-styles', 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
		wp_enqueue_style('wp-show-modal-styles');
		wp_register_style('wp-show-modal-to-unregistered-users-css', plugin_dir_url(__FILE__).'css/wp-show-modal-to-unregistered-users.css');
		wp_enqueue_style('wp-show-modal-to-unregistered-users-css');
		wp_register_script('wp-show-modal-to-unregistered-users-js', plugin_dir_url(__FILE__).'js/wp-show-modal-to-unregistered-users.js', array('jquery'), '1', true);
		wp_enqueue_script('wp-show-modal-to-unregistered-users-js');
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