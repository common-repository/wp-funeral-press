<?php
/*
Plugin Name: WP FuneralPress
Plugin URI: http://www.wpfuneralpress.com
Description: An Obituary Plugin For Funeral Homes and Cemeteries
Author: Anthony Brown
Version: 1.5.5
Author URI: http://www.wpfuneralpress.com
*/

load_plugin_textdomain( 'sp-wpfh', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

global $wpfh_version;
$wpfh_version = "1.5.5";
ini_set('memory_limit', '-1');
//includes
include ''.dirname(__FILE__).'/includes/common.php';
require_once ''.dirname(__FILE__).'/includes/pagination.php';


include ''.dirname(__FILE__).'/admin/obits.php';
$wpfh_obits_admin = new wpfh_obits_admin;

include ''.dirname(__FILE__).'/admin/guestbook.php';
$wpfh_obits_guestbook = new wpfh_obits_guestbook;

include ''.dirname(__FILE__).'/includes/install.php';
$wpfh_install = new wpfh_install;
include ''.dirname(__FILE__).'/admin/tools.php';
include ''.dirname(__FILE__).'/admin/settings.php';
$wpfh_settings = new wpfh_settings;

add_filter('wpfh_settings_submenu', array($wpfh_settings,'submenu') ); 	

include ''.dirname(__FILE__).'/user/shortcodes.php';
include ''.dirname(__FILE__).'/user/widget-search.php';
include ''.dirname(__FILE__).'/user/widget-obits.php';
include ''.dirname(__FILE__).'/user/obits.php';


if($_GET['wpfh_reinstall_db'] == 1){
	
$wpfh_notice .= $wpfh_install->install();

if(class_exists('wpfh_cem_scripts')){
	
$wpfh_notice .= $wpfh_cem_scripts->install();
	
}

echo $wpfh_notice;	
}


//install and hooks
register_activation_hook(__FILE__,  array($wpfh_install ,'install'));
register_activation_hook(__FILE__,  array($wpfh_install ,'install'));
add_action('admin_menu', array($wpfh_install ,'menu'));
add_action('wp_loaded', array($wpfh_install ,'check_exists'));




add_action('admin_bar_menu',array($wpfh_install ,'admin_bar'), 100);





define('WPFH_FOLDER',plugins_url('', __FILE__) );

// css and javascript hooks
class wpfh_scripts{
	
	function version($version_info){
	global $wpfh_version;
		$version_info.= '<strong>Community Edition:</strong> '.$wpfh_version .'';
		return $version_info;
	}
	function seo(){
		
		do_action('wpfh_permalink_structure');
		
	}
	function google_recaptcha(){
		
	if(!class_exists('ReCaptchaResponse')){	
	require_once ''.dirname(__FILE__).'/includes/recaptcha.php';	
	}
	}
	function __construct(){
		
		
	
		
	}
	function footer(){
		global $wpdb,$current_user;
	echo '<input type="hidden" id="wpfh_folder" value="'.plugins_url('', __FILE__) .'">
		  <input type="hidden" id="wpfh_ajax_url" value="'.plugins_url('/ajax.php', __FILE__) .'">	';	
		  
		  
		if ( is_user_logged_in() ) {
		
		echo '<input type="hidden" id="wpfh_user_logged_in" value="'.$current_user->ID.'">';
		}else{
		echo '<input type="hidden" id="wpfh_user_logged_in" value="0">';	
		}
	}
	
function js(){
	
				wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	add_thickbox();
			  wp_enqueue_script( 'jquery-ui-core',array('jquery'));
			   wp_enqueue_script( 'jquery-ui-dialog',array('jquery') );
			   wp_enqueue_script( 'jquery-ui-accordion',array('jquery') );
			   wp_enqueue_script( 'jquery-ui-tabs',array('jquery') );
			   wp_enqueue_script( 'jquery-ui-datepicker' ,array('jquery'));
			   wp_enqueue_script( 'jquery-effects-core',array('jquery') );
			    wp_enqueue_script('jquery-print', plugins_url('js/jquery.print.js', __FILE__),array('jquery','jquery-ui-core', 'jquery-ui-tabs','jquery-ui-datepicker'));
				
			   
			    wp_enqueue_script('wpfh-js-scripts', plugins_url('js/scripts.js', __FILE__),array('jquery'));
				 wp_enqueue_script('wpfh-adminmenu', plugins_url('js/adminmenu.js', __FILE__),array('jquery'));
				 wp_enqueue_script('jquery-cookie', plugins_url('js/jquery.cookie.js', __FILE__),array('jquery'));
				  wp_enqueue_script('wpfh-facebook', plugins_url('js/facebook.js', __FILE__),array('jquery'));
}

function css(){
	
	wp_register_style( 'wpfh-style',plugins_url('/css/style.css', __FILE__) );
	 wp_enqueue_style( 'wpfh-style' );
	if(file_exists(''.get_stylesheet_directory().'/obits.css')){
wp_register_style( 'wpfh-style-custom',''.get_stylesheet_directory_uri().'/obits.css');
	wp_enqueue_style( 'wpfh-style-custom', array('wpfh-style'));
	}
	
		wp_register_style( 'wpfh-tabs',plugins_url('/css/tabs.css', __FILE__) );
	
	
	  wp_enqueue_style( 'wpfh-tabs' );
	  

	
	  
	 
	  if(get_option('wpfp_jqueryui_theme') != 'none'){
	  if(get_option('wpfp_jqueryui_theme') == ''){
			
			$theme = 'smoothness';
		}else{
			$theme = get_option('wpfp_jqueryui_theme');
	}		
	  
	 
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    	wp_register_style( 'jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/'.$theme .'/jquery-ui.min.css');
		}else{
		 wp_register_style( 'jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/'.$theme .'/jquery-ui.min.css');	
		}
		
  wp_enqueue_style( 'jquery-ui-css' );	
	  }
}


function admin_css(){
	
		  if(get_option('wpfp_jqueryui_theme') != 'none'){
	  if(get_option('wpfp_jqueryui_theme') == ''){
			
			$theme = 'smoothness';
		}else{
			$theme = get_option('wpfp_jqueryui_theme');
	}		
	  
	 
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    	wp_register_style( 'jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/'.$theme .'/jquery-ui.min.css');
		}else{
		 wp_register_style( 'jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/'.$theme .'/jquery-ui.min.css');	
		}
		
  wp_enqueue_style( 'jquery-ui-css' );	
	  }
  
  wp_register_style( 'wpfh-admin-menu',plugins_url('/css/cssmenu.css', __FILE__) );
  wp_enqueue_style( 'wpfh-admin-menu' );	
  
}
 
function editor_admin_init() {
  wp_enqueue_script('word-count');
  wp_enqueue_script('post');
  wp_enqueue_script('editor');
  wp_enqueue_script('media-upload');
}
 
function editor_admin_head() {

}
}


// javascript and css
$wpfh_scripts = new wpfh_scripts;
//add_action('wp_head', array($wpfh_scripts ,'css'));	
add_filter('wpfp_version_info', array($wpfh_scripts ,'version'));	
add_action('wp_head', array($wpfh_scripts , 'seo'));
add_action('wp_print_styles', array($wpfh_scripts ,'css'));

add_action('init', array($wpfh_scripts ,'js'));
add_action('admin_menu', array($wpfh_scripts ,'css'));
add_action('admin_menu', array($wpfh_scripts ,'admin_css'));
//editor in admin
add_action('admin_init',  array($wpfh_scripts ,'editor_admin_init'));
add_action('admin_head',  array($wpfh_scripts ,'editor_admin_head'));

add_action('wp_footer', array($wpfh_scripts,'footer'));

	add_action( 'after_setup_theme', array($wpfh_scripts,'google_recaptcha'));


  if(function_exists('tml_register_form')){
  function tml_new_user_registered( $user_id ) {
	wp_set_auth_cookie( $user_id, false, is_ssl() );
	$referer = remove_query_arg( array( 'action', 'instance' ), wp_get_referer() );
	wp_redirect( $referer );
	exit;
}
add_action( 'tml_new_user_registered', 'tml_new_user_registered' );

function tml_register_form() {
	wp_original_referer_field( true, 'previous' );
}
add_action( 'register_form', 'tml_register_form' );
  }
  
  

  
  if(get_option('wpfh_obit_w') == '' && get_option('wpfh_obit_h') == ''){
	update_option('wpfh_obit_w', 250); update_option('wpfh_obit_h', 250);	
  }
  
    if(get_option('wpfh_obits_w') == '' && get_option('wpfh_obits_h') == ''){
	update_option('wpfh_obit_w', 150); update_option('wpfh_obit_h', 150);	
  }
    if(get_option('wpfh_obitsh_w') == '' && get_option('wpfh_obitsh_h') == ''){
	update_option('wpfh_obitsh_w', 80); update_option('wpfh_obitsh_h', 80);	
  }
    if(get_option('wpfh_obitw_w') == '' && get_option('wpfh_obitw_h') == ''){
	update_option('wpfh_obitw_w', 150); update_option('wpfh_obitw_h', 150);	
  }
  
  
?>