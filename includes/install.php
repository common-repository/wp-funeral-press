<?php
class wpfh_install{
	
	function admin_bar($admin_bar){
		global $wpdb,$current_user,$post;
		if(current_user_can('wpfh_manage_obits')){
		$admin_bar->add_menu( array(
		'id'    => 'manage-obits',
		'title' => 'Manage Obituaries',
		'href'  => get_admin_url().'admin.php?page=wpfh',	
		'meta'  => array(
			'title' => __('Manage Obituaries',"sp-wpfh"),			
		),
		));
					
		}
		
		
		if(wpfh_obit_page_id() == $post->ID && $_GET['id'] != '' && current_user_can('wpfh_manage_obits')){
			
		$admin_bar->add_menu( array(
		'id'    => 'manage-obits-entry',
		'title' => 'Edit This Obituary',
		'href'  => get_admin_url().'admin.php?page=wpfh&id='.$_GET['id'] .'',	
		'meta'  => array(
			'title' => __('Edit This Obituary',"sp-wpfh"),			
		),
		));	
			
		}
		$search = apply_filters("wpfh_admin_search_guestbook_query", $search);
		$r_pending = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_posts where approved = 0 ".$search."", ARRAY_A);
		if(current_user_can('wpfh_manage_guestbook') && count($r_pending) > 0){
					
					
		$admin_bar->add_menu( array(
		'id'    => 'manage-guestbook',
		'title' => ''.count($r_pending).' Pending Guestbook Post(s)',
		'href'  => get_admin_url().'admin.php?page=wpfh-guestbook',	
		'meta'  => array(
		'title' => sprintf(__("%s Pending Guestbook Post(s)","sp-wpfh"),count($r_pending))		
		),
		));
					
		}
		do_action('wpfh_admin_bar');
		

	}
	
function check_exists(){
	
		global $wpfh_errors,$wpdb,	$wpfh_version;
	$table_name = "".$wpdb->prefix ."wpfh_obits";
		if($wpdb->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name) {
		$this->install();
		}
	
if(get_option("wpfh_version") == '1.0.0' or
   get_option("wpfh_version") == '1.0.1'  or
   get_option("wpfh_version") == '1.0.2'  or
   get_option("wpfh_version") == '1.0.3'  or
   get_option("wpfh_version") == '1.0.4'  or
   get_option("wpfh_version") == '1.0.5'  or
   get_option("wpfh_version") == '1.0.6'  or
   get_option("wpfh_version") == '1.0.7'  or
   get_option("wpfh_version") == '1.0.8' or  $_GET['wpfh_reinstall_db'] == 1 ){
	   
	   // updates for 1.0.9
	   $wpdb->query("ALTER TABLE `".$wpdb->prefix ."wpfh_posts` ADD `name` VARCHAR( 255 ) NOT NULL ,
ADD `email` VARCHAR( 255 ) NOT NULL; ");	

	   	update_option('wpfh_version', '1.0.8');
   }

if(get_option("wpfh_version") <= '1.3.2' or $_GET['wpfh_reinstall_db'] == 1){
	   $wpdb->query("ALTER TABLE `".$wpdb->prefix ."wpfh_obits` ADD `lat` VARCHAR( 255 ) NOT NULL ,
					ADD `lon` VARCHAR( 255 ) NOT NULL,
					ADD  `created` TIMESTAMP NOT NULL; ");	
			update_option('wpfh_version', '1.3.2');		
				
}


if(get_option('wpfh_version') <= '1.3.8' or $_GET['wpfh_reinstall_db'] == 1){
 $wpdb->query("ALTER TABLE ".$wpdb->prefix ."wpfh_obits MODIFY COLUMN created TIMESTAMP;");	
	update_option('wpfh_version', '1.3.8');	
}


    $administrator = get_role( 'administrator' );
	
    $administrator->add_cap( 'wpfh_manage_obits' ); 
	$administrator->add_cap( 'wpfh_manage_guestbook' );
	$administrator->add_cap( 'wpfh_manage_settings' );
	$administrator->add_cap( 'wpfh_manage_sections' );
$administrator->add_cap( 'wpfh_manage_churches' );
$administrator->add_cap( 'wpfh_manage_funeral_homes' );
	
	do_action('wpfh_upgrade_hook');
}
	
	
	
function error($text,$type){
	
	
	
	return '<div class="wpfh_error_'.$type.'">'.$text.'</div>';
}
	
function topMenu($name,$submenu = NULL){
	
		global $wpfh_errors,$wpdb;
		
		
		
		$html .='<div id="wpfh_cssmenu"><ul>';
					
					
			//obits menu
			if(current_user_can('wpfh_manage_obits')){
  			 $html .=' <li class="has-sub"><a href="admin.php?page=wpfh">'.get_option('wpfh_obit_name_plural').'</a>
  			  <ul>
			 	 <li><a href="admin.php?page=wpfh&function=add">Add '.get_option('wpfh_obit_name').'</a></li>';
						
						$obit_submenu_items = '';
						$obit_submenu_items .= apply_filters('wpfh_obit_submenu',$obit_submenu_items);
						$html .= $obit_submenu_items;
				 	
              $html .='</ul>   
   			  </li>';	
			}
			  //end obits menu
			  
			  
   			//guestbook menu
			if(current_user_can('wpfh_manage_guestbook')){
  		 if(get_option('wpfh_disable_guestbook') != 1){
		$html .=' <li class="has-sub"><a href="admin.php?page=wpfh-guestbook" > '.wpfh_gb_word().'</a>
					<ul>
					  <li><a href="admin.php?page=wpfh-guestbook">'.sprintf(__("View %s postings","sp-wpfh"),wpfh_gb_word()).'</a></li>';
					  	
						$guestbook_submenu_items = '';
						$guestbook_submenu_items .= apply_filters('wpfh_guestbook_submenu',$guestbook_submenu_items);
						$html .= $guestbook_submenu_items;
						
              		$html .='</ul> 
				</li> ';
		}
			}
			//end guestbook menu
			
			
			
			//all other top menu items
			if(current_user_can('wpfh_manage_obits')){
			$top_menu_items = '';
			$top_menu_items .= apply_filters('wpfh_top_menu',$top_menu_items);
			$html .= $top_menu_items;
			}
			//end all other top menu items
			
		//settings submenu	
		if(current_user_can('wpfh_manage_settings')){
			$html .='<li class="has-sub"><a href="admin.php?page=wpfh-settings">'.__("Settings","sp-wpfh").'</a>
					<ul>
					  <li><a href="admin.php?page=wpfh-settings">'.__("View Settings","sp-wpfh").'</a></li>';
					  	$settings_submenu_items = '';
						$settings_submenu_items .= apply_filters('wpfh_settings_submenu',$settings_submenu_items);
						$html .= $settings_submenu_items;
					  
              		$html .='</ul> 
			</li>';	
		}
		//end settings submenu	
  
  $html .='
  
</ul><div style="clear:both"></div>
</div><div style="text-align:right;padding-right:25px;"> ';

$version_info  = '';
$version_info .= apply_filters('wpfp_version_info', $version_info);

$html .=''.$version_info.'<span style="margin-left:20px"> '. date("F j, Y g:i a",current_time( 'timestamp' )).'</span></div>';
		
		
		
		
		
		
	
		
		
		
	
		$html .='<h1 class="topmenu-header">'.$name.'</h1>';
		
		$search = apply_filters("wpfh_admin_search_guestbook_query", $search);
$r_pending = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_posts where approved = 0 ".$search."", ARRAY_A);
if(count($r_pending) > 0){	
	$html .= wpfh_install::error('You have ('.count($r_pending).') pending guestbook posts waiting to be approved, <a href="admin.php?page=wpfh-guestbook">click here to approve them</a>', 'info');

}
	
	
	if($_GET['dismiss-nag'] != ''){
	update_option('wpfh_nag', 	$_GET['dismiss-nag']);
	}
	
	if((get_option('wpfh_nag') == '' or  get_option('wpfh_nag') == 0) && !class_exists('wpfh_premium')){
		
		
	
	$html .='<div class="wpfh_nag"><div style="float:right;padding-right:10px"><a href="admin.php?page=wpfh&dismiss-nag=1" class="button">Dismiss this message</a></div><h2 style="clear:both">Upgrade to premium</h2>
					<p>Upgrade to premium to enjoy many more benefits including, funeral home mapping, cemetery mapping, advances guestbook messages, obituary subscriptions, More styles and much more.</p>
					<p><a href="http://wpfuneralpress.com/signup/" class="button" target="_blank" style="background-color:#c1e7ff">Click here to see all the features</a></p>
					</div>';	
	}
			
	if(wpfh_obit_page_id() == false){
	$html .= $this->error('<div class="wpfh_error">Please add the shortcode<strong> [funeralpress] </strong>on a page for this plugin to work properly.</div>', 'error');	
	}
	
			
	if($_GET['ignore'] == 'tml'){
		add_option('fp_ignore_tml',1);	
		}
	
	if(!function_exists('theme_my_login') && get_option('fp_ignore_tml') != 1){
	$html .= '<div class="wpfh_error">This plugin works great with the "Theme My Login" plugin which allows you to use your own template for login and registration. <strong>Please remember to turn on registration in your wordpress settings if you need to have users registering</strong>.<div style="padding:10px"> <a href="plugin-install.php?tab=search&s=theme+my+login&plugin-search-input=Search+Plugins" class="button">Click here to get theme my login.</a> or <a href="admin.php?page=wpfh&ignore=tml" class="button">click here to ignore this message</a>.</div></div>';	
	}
	
		
	
		echo $html;
		
		do_action('wpfh_error');
	
}

function menu(){
	global $wpdb,$wpfh_obits_admin,$wpfh_settings,$wpfh_obits_guestbook;
	
	 
	 add_menu_page( 'Obituaries', 'Obituaries',  'wpfh_manage_obits', 'wpfh', array($wpfh_obits_admin ,'view'),'dashicons-id-alt');
	add_submenu_page( 'wpfh', 'Settings',  'Settings',  'wpfh_manage_settings', 'wpfh-settings', array($wpfh_settings ,'view'));
	add_submenu_page( 'wpfh', 'Email Settings',  'Email Settings',  'wpfh_manage_settings', 'wpfh-settings-email', array($wpfh_settings ,'email'));
	add_submenu_page( 'wpfh', 'Custom CSS',  'Custom CSS',  'wpfh_manage_settings', 'wpfh-custom-css', array($wpfh_settings ,'css'));
	add_submenu_page( 'wpfh', 'Guest Book',  'Guest Book',  'wpfh_manage_guestbook', 'wpfh-guestbook', array($wpfh_obits_guestbook ,'view'));
	
	do_action('wpfh_menu');
}

function install(){
	
	global $wpdb,$wpfh_version;
	
		
	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	$tables = $this->db_tables();
	foreach($tables as $key => $value){
		  if($value != ""){
		  dbDelta($value);
			$notice .= '<strong>Installed '.$key.'</strong><br>';
		  }
	}
	
	$alters = $this->db_alters();
	foreach( $alters as $key => $value){
		  if($value != ""){
		  $wpdb->query($value);
		  }
	}
	if(get_option('wpfh_obit_name') == ''){
	add_option("wpfh_obit_name", "Obituary");
	add_option("wpfh_obit_name_plural", "Obituaries");
	add_option("wpfh_obit_display_num", "25");
	add_option('wpfh_enable_search','1' );
	add_option('wpfh_obit_style', 'block');
	
	add_option('wpfh_email_admin', 'Dear Admin

There has been a new guestbook posting by [user] on [obit]

Click here to approve: [link]');
	add_option('wpfh_email_user', 'Dear [user],

Thank you for posting on [obit]\'s guestbook page, once your message has been approved we will email you.');
	add_option('wpfh_email_user_approved', 'Dear [user],

Your guestbook posting has been approved. Please follow the following link to view the guestbook page: [link]');
	
	
	add_option('wpfh_email_admin_subject', 'New Guest Posting');
	add_option('wpfh_email_user_subject', 'Thank you for your guestbook posting');
	add_option('wpfh_email_user_approved_subject','Your guestbook posting has been approved');
	
	}
	
	if(get_option('wpfh_version') < '1.3.8'){
		  $wpdb->query("ALTER TABLE ".$wpdb->prefix ."wpfh_obits MODIFY COLUMN created TIMESTAMP;");	
	
	}
	update_option("wpfh_version", $wpfh_version);
	return $notice;
}
	
function db_tables(){
	global $wpdb;
	$sql = array(
	
	"".$wpdb->prefix ."wpfh_obits" =>
	"CREATE TABLE  `".$wpdb->prefix ."wpfh_obits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` text NOT NULL,
  `birth_date`  date NOT NULL DEFAULT '0000-00-00',
  `death_date`  date NOT NULL DEFAULT '0000-00-00',
  `obituary` text NOT NULL,
  `visitation_time` text NOT NULL,
   `obit_notes` text NOT NULL,
  `service_time` text NOT NULL,
  `middle` varchar(255) NOT NULL DEFAULT '',
  `section` varchar(255) NOT NULL DEFAULT '',
  `lot_number` varchar(255) NOT NULL DEFAULT '',
  `grave_number` varchar(255) NOT NULL DEFAULT '',
  `burial_date` date NOT NULL DEFAULT '0000-00-00',
  `photo` text NOT NULL,
  `flowers` text NOT NULL,
  `count` int(25) NOT NULL DEFAULT '0',
  `page` varchar(100) NOT NULL DEFAULT '',
  `vet` int(1) NOT NULL DEFAULT '0',
  `maiden` text NOT NULL,
  `funeralhome` varchar(255) NOT NULL DEFAULT '',
  `placeofservice` varchar(255) NOT NULL DEFAULT '',
  `sports` text NOT NULL,
  `frat` text NOT NULL,
  `org` text NOT NULL,
  `edu` text NOT NULL,
  `disabled` int(1) NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `cemid` varchar(255) NOT NULL DEFAULT '1',
  `approved` int(1) NOT NULL DEFAULT '1',
  `package` int(11) NOT NULL DEFAULT '1',
  `photosleft` int(11) NOT NULL DEFAULT '10',
  `tribpackage` int(11) NOT NULL DEFAULT '1',
  `tribleft` int(11) NOT NULL DEFAULT '1',
  `affiliations` text NOT NULL,
  `group` int(1) NOT NULL DEFAULT '0',
  `headstone` varchar(255) NOT NULL,
  `cemetery` int(11) NOT NULL ,
  `cemetery_notes` varchar(255) NOT NULL ,
  `lon` varchar(255) NOT NULL ,
  `lat` varchar(255) NOT NULL ,
  `created` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`)
);",
"".$wpdb->prefix ."wpfh_posts" =>
	"CREATE TABLE  `".$wpdb->prefix ."wpfh_posts` (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0',
  `oid` int(11) NOT NULL,
  `anonymous` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
	);"


	
	);	
	return 	$sql;
}
function db_alters(){
	global $wpdb;
		$sql = array(
	
	"ALTER TABLE `".$wpdb->prefix ."wpfh_posts` ADD `name` VARCHAR( 255 ) NOT NULL ,
ADD `email` VARCHAR( 255 ) NOT NULL; "
	
	);	
	return 	$sql;
}
}

?>